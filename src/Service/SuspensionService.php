<?php

declare(strict_types=1);

namespace App\Service;

use DateTime;
use App\Entity\SuspensionDetails;
use App\Repository\SuspensionDetailsRepository;
use App\Repository\SuspensionReasonRepository;
use App\Repository\StudentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
class SuspensionService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SuspensionReasonRepository $suspensionReasonRepository,
        private readonly StudentsRepository $studentsRepository,
        private readonly SluggerInterface $slugger,
        private readonly SuspensionDetailsRepository $suspensionDetailRepo
    ) {}

    public function createSuspension(Request $request): array
    {
        $studentId = $request->request->get('student_id');
        $suspensionReasonId = $request->request->get('reason_id');
        $startDate = $request->request->get('suspended_from');
        $endDate = $request->request->get('suspended_until');
        $decisionMadeTime = $request->request->get('decision_made_time');
        $note = $request->request->get('notes');
        $document = $request->files->get('document');

        $errors = [];

        if (empty($studentId)) {
            $errors['student_id'] = 'Student is required.';
        }

        if (empty($suspensionReasonId)) {
            $errors['suspension_reason_id'] = 'Suspension Reason is required.';
        }

        if (empty($startDate)) {
            $errors['start_date'] = 'Start Date is required.';
        }

        if (empty($endDate)) {
            $errors['end_date'] = 'End Date is required.';
        }

        if ((!empty($startDate)) && (!empty($endDate)) && new DateTime($endDate) < new DateTime($startDate)) 
        {
            $errors['end_date'] = 'End Date cannot be before Start Date.';
        }

        if (empty($decisionMadeTime)) {
            $errors['decision_made_time'] = 'Decision Made Time is required.';
        }

        if ((!empty($decisionMadeTime)) &&
            (!empty($startDate)) &&
            new DateTime($decisionMadeTime) > new DateTime($startDate)
        ) 
        {
            $errors['decision_made_time'] = 'Decision Made Time cannot be after Start Date.';
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $student = $this->studentsRepository->find($studentId);
        $suspensionReason = $this->suspensionReasonRepository->find($suspensionReasonId);

        if (!$student) {
            return ['success' => false, 'errors' => ['student_id' => 'Invalid Student selected.']];
        }

        if (!$suspensionReason) {
            return ['success' => false, 'errors' => ['suspension_reason_id' => 'Invalid Suspension Reason selected.']];
        }
        
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);

        $current = clone $start;
        $daysLost = 0;

        while($current <= $end)
        {
            $dayOfWeek = (int) $current->format('N');
            if($dayOfWeek!=6 && $dayOfWeek!=7){
                $daysLost++;
            }
            $current->modify('+1 day');
        }

        $suspensionDetail = new SuspensionDetails();
        $suspensionDetail->setStudent($student);
        $suspensionDetail->setSuspensionReason($suspensionReason);
        $suspensionDetail->setSuspendedFrom(new DateTime($startDate));
        $suspensionDetail->setSuspendedUntil(new DateTime($endDate));
        $suspensionDetail->setDecisionMadeTime(new DateTime($decisionMadeTime));
        $suspensionDetail->setDaysLost($daysLost);
        $suspensionDetail->setSuspensionNotes($note);

         if($document){
            $originalFilename = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFileName = $safeFilename.'-'.uniqid().'.'.$document->guessExtension();
            try{
                $document->move('uploads/',$newFileName);
                $suspensionDetail->setDocumentPath('uploads/'.$newFileName);
            }catch(FileException $e){
                return [
                    'success'=>false,
                    'errors' => [ 'document' => 'File upload failed']
                ];
            }
         }
        $this->entityManager->persist($suspensionDetail);
        $this->entityManager->flush();

        return ['success' => true,
        'errors' => [],
        ];
    }
    public function getSuspensionDetails(): array
    {
        $suspensionDetails = $this->entityManager->getRepository(SuspensionDetails::class)->findAll();
        $result = [];

        foreach ($suspensionDetails as $detail) {
            $result[] = [
                'student' => $detail->getStudent()->getFirstName() . ' ' . $detail->getStudent()->getLastName(),
                'suspensionReason' => $detail->getSuspensionReason()->getSuspensionReason(),
                'suspendedFrom' => $detail->getSuspendedFrom()->format('Y-m-d'),
                'suspendedUntil' => $detail->getSuspendedUntil()->format('Y-m-d'),
                'decisionMadeTime' => $detail->getDecisionMadeTime()->format('Y-m-d H:i:s'),
                'daysLost' => $detail->getDaysLost(),
                'notes' => $detail->getSuspensionNotes(),
                'document' => $detail->getDocumentPath()
            ];
        }

        return $result;
    }

    public function getSuspensionStats():array
    {
        return $this->suspensionDetailRepo->getSuspensionStatistics();
    }
}
