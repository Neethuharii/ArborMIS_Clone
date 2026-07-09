<?php

declare(strict_types=1);

namespace App\Service;

use DateTime;
use DateTimeImmutable;
use App\Entity\BehaviourIncidents;
use App\Entity\StudentPoints;
use App\Entity\Behaviours;
use App\Entity\InterventionDetail;
use App\Repository\StudentsRepository;
use App\Repository\StaffsRepository;
use App\Repository\BehavioursRepository;
use App\Repository\InterventionRepository;
use App\Repository\BehaviourIncidentsRepository;
use App\Repository\StudentPointsRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class IncidentService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly StudentsRepository $studentRepo,
        private readonly StaffsRepository $staffsRepo,
        private readonly BehavioursRepository $behaviourRepo,
        private readonly InterventionRepository $interventionRepo,
        private readonly BehaviourIncidentsRepository $incidentRepo,
         private readonly StudentPointsRepository $studentPointsRepo
    ) {
    }

    public function createIncident(Request $request): array
    {
        $incidentDate = $request->request->get('incident_date');
        $incidentTime = $request->request->get('incident_time');
        $studentsInvolvedId = $request->request->all('students');
        $behaviourId = $request->request->get('behaviour_id');
        $assignedStaffId = $request->request->get('assigned_staff');
        $summary = $request->request->get('incident_summary');
        $involvedStaffId = $request->request->all('staff_involved');
        $interventionStudentId = $request->request->all('intervention_student');
        $interventionStaffId = $request->request->all('intervention_staff');
        $interventionMethodId = $request->request->all('intervention_method');

        $errors = [];

        if (empty($incidentDate)) {
            $errors['incident_date'] = 'incident date is required';
        }

        if (empty($incidentTime)) {
            $errors['incident_time'] = 'incident time is required';
        }

        if (empty($studentsInvolvedId)) {
            $errors['students_involved'] = 'students cannot be empty';
        }

        if (empty($behaviourId)) {
            $errors['behaviour'] = 'select a behaviour for the incident';
        }

        if (empty($assignedStaffId)) {
            $errors['assigned_staff'] = 'please select a staff';
        }

        if (!empty($interventionStudentId)) {
            foreach ($interventionStudentId as $student) {
                if (!in_array($student, $studentsInvolvedId)) {
                    $errors['intervention_student'] =
                        'student selected in intervention should be present in student involved';
                    break;
                }
            }
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors
            ];
        }

        $studentsInvolved = $this->studentRepo->findBy([
            'studentId' => $studentsInvolvedId
        ]);

        /** @var Behaviours|null $behaviour */
        $behaviour = $this->behaviourRepo->find($behaviourId);

        if (!$behaviour) {
            return [
                'success' => false,
                'errors' => [
                    'behaviour' => 'invalid behaviour selected'
                ]
            ];
        }

        $assignedStaff = $this->staffsRepo->find($assignedStaffId);

        if (!$assignedStaff) {
            return [
                'success' => false,
                'errors' => [
                    'assigned_staff' => 'selected invalid staff'
                ]
            ];
        }

        $involvedStaff = $this->staffsRepo->findBy([
            'staffId' => $involvedStaffId
        ]);

        $interventionStudent = $this->studentRepo->findBy([
            'studentId' => $interventionStudentId
        ]);

        $interventionStaff = $this->staffsRepo->findBy([
            'staffId' => $interventionStaffId
        ]);

        $interventionMethod = $this->interventionRepo->findBy([
            'interventionId' => $interventionMethodId
        ]);

        $createdIncident = null;

        if ($request->request->has('create_separate')) {

            foreach ($studentsInvolved as $student) {

                $behaviourIncident = new BehaviourIncidents();
                $behaviourIncident->setIncidentDate(new DateTime($incidentDate));
                $behaviourIncident->setIncidentTime(new DateTime($incidentTime));
                $behaviourIncident->addStudentInvolved($student);
                $behaviourIncident->setBehaviour($behaviour);
                $behaviourIncident->setAssignedStaff($assignedStaff);
                $behaviourIncident->setIncidentSummary($summary);
                $behaviourIncident->setCreatedAt(new DateTimeImmutable());

                foreach ($involvedStaff as $staff) {
                    $behaviourIncident->addStaffInvolved($staff);
                }

                $this->entityManager->persist($behaviourIncident);

                if (!empty($interventionStudent)) {
                    foreach ($interventionStudent as $index => $interventionStd) {
                        if ($interventionStd->getStudentId() == $student->getStudentId()) {

                            $interventionDetail = new InterventionDetail();
                            $interventionDetail->setBehaviourIncident($behaviourIncident);
                            $interventionDetail->setStudent($interventionStd);
                            $interventionDetail->setStaff($interventionStaff[$index]);
                            $interventionDetail->setIntervention($interventionMethod[$index]);

                            $this->entityManager->persist($interventionDetail);
                        }
                    }
                }

                $createdIncident = $behaviourIncident;
            }

        } else {

            $behaviourIncidents = new BehaviourIncidents();
            $behaviourIncidents->setIncidentDate(new DateTime($incidentDate));
            $behaviourIncidents->setIncidentTime(new DateTime($incidentTime));

            foreach ($studentsInvolved as $student) {
                $behaviourIncidents->addStudentInvolved($student);
            }

            $behaviourIncidents->setBehaviour($behaviour);
            $behaviourIncidents->setAssignedStaff($assignedStaff);
            $behaviourIncidents->setIncidentSummary($summary);
            $behaviourIncidents->setCreatedAt(new DateTimeImmutable());

            foreach ($involvedStaff as $staff) {
                $behaviourIncidents->addStaffInvolved($staff);
            }

            $this->entityManager->persist($behaviourIncidents);

            if (!empty($interventionStudent)) {
                foreach ($interventionStudent as $index => $student) {

                    $interventionDetail = new InterventionDetail();
                    $interventionDetail->setBehaviourIncident($behaviourIncidents);
                    $interventionDetail->setStudent($student);
                    $interventionDetail->setStaff($interventionStaff[$index]);
                    $interventionDetail->setIntervention($interventionMethod[$index]);

                    $this->entityManager->persist($interventionDetail);
                }
            }

            $createdIncident = $behaviourIncidents;
        }
        
        foreach ($studentsInvolved as $student) {

            $studentPoint = $student->getStudentPoints();

            if (!$studentPoint) {
                $studentPoint = new StudentPoints();
                $studentPoint->setStudent($student);
                $studentPoint->setTotalPoints(0);
            }

            $newPoint = $studentPoint->getTotalPoints()
                + $behaviour->getCategory()->getCategoryPoints();

            $studentPoint->setTotalPoints($newPoint);
            $studentPoint->setUpdatedAt(new DateTimeImmutable());

            $this->entityManager->persist($studentPoint);
        }

        $this->entityManager->flush();

        return [
            'success' => true,
            'incident' => [
                'incidentDate' => $createdIncident->getIncidentDate()->format('Y-m-d'),
                'incidentTime' => $createdIncident->getIncidentTime()->format('H:i'),
                'severity' => $createdIncident->getBehaviour()->getCategory()->getCategoryName(),
                'behaviour' => $createdIncident->getBehaviour()->getBehaviourName(),
                'students' => array_map(
                    fn($student) => $student->getFirstName() . ' ' . $student->getLastName(),
                    $createdIncident->getStudentInvolved()->toArray()
                )
            ]
        ];
    }
    public function searchRecentPoints(string $search): array
    {
        return $this->incidentRepo->searchRecentPoints($search);
    }

    public function searchTotalPoints(string $search): array
    {
        return $this->studentPointsRepo->searchTotalPoints($search);
    }
    
    public function incidentsSearch(string $search): array
    {
        $incidents = $this->incidentRepo->incidentsSearch($search);

        $result = [];

        foreach ($incidents as $incident) {

            $students = [];

            foreach ($incident->getStudentInvolved() as $student) {
                $students[] = $student->getFirstName() . ' ' . $student->getLastName();
            }

            $result[] = [
                'incidentDate' => $incident->getIncidentDate()->format('Y-m-d'),
                'incidentTime' => $incident->getIncidentTime()->format('H:i'),
                'categoryName' => $incident->getBehaviour()->getCategory()->getCategoryName(),
                'behaviourName' => $incident->getBehaviour()->getBehaviourName(),
                'students' => implode(' and ', $students),
            ];
        }

        return $result;
    }
}