<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'category_id', type:'integer')]
    private ?int $categoryId = null;

    #[ORM\Column(name:'category_name', length: 50)]
    private ?string $categoryName = null;

    #[ORM\Column(name:'category_points')]
    private ?int $categoryPoints = null;

    /**
     * @var Collection<int, Behaviours>
     */
    #[ORM\OneToMany(targetEntity: Behaviours::class, mappedBy: 'category')]
    private Collection $behaviours;

    public function __construct()
    {
        $this->behaviours = new ArrayCollection();
    }

    public function getcategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): static
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    public function getCategoryPoints(): ?int
    {
        return $this->categoryPoints;
    }

    public function setCategoryPoints(int $categoryPoints): static
    {
        $this->categoryPoints = $categoryPoints;

        return $this;
    }

    /**
     * @return Collection<int, Behaviours>
     */
    public function getBehaviours(): Collection
    {
        return $this->behaviours;
    }

    public function addBehaviour(Behaviours $behaviour): static
    {
        if (!$this->behaviours->contains($behaviour)) {
            $this->behaviours->add($behaviour);
            $behaviour->setCategory($this);
        }

        return $this;
    }

    public function removeBehaviour(Behaviours $behaviour): static
    {
        if ($this->behaviours->removeElement($behaviour)) {
            if ($behaviour->getCategory() === $this) {
                $behaviour->setCategory(null);
            }
        }

        return $this;
    }
}
