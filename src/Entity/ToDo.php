<?php

namespace App\Entity;

use App\Entity\EmailSenderService;
use App\Repository\UserRepository;
use App\Repository\ToDoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ToDoRepository::class)]
class ToDo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'toDo', targetEntity: Item::class)]
    private Collection $item;

    public function __construct()
    {
        $this->item = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItem(): Collection
    {
        return $this->item;
    }

    public function addItem(Item $item): self
    {

        // Vérifie la limite d'items par ToDo
        if ($this->item->count() >= 10) {
            throw new \RuntimeException("La limite de 10 items par todo a été atteinte.");
        }
    
        // Vérifie que l'item a un nom unique
        $itemName = $item->getName();
        foreach ($this->item as $existingItem) {
            if ($existingItem->getName() === $itemName) {
                throw new \RuntimeException("Un item avec le même nom existe déjà.");
            }
        }
        // Vérifie que le nom est renseigné
        if($item->getName() == "" || $item->getName() == null) {
            throw new \RuntimeException("L'item ne possède pas de nom");
        }

        // Vérifie la longueur maximale du contenu
        $content = $item->getContent();
        if ($content !== null && mb_strlen($content) > 1000) {
            throw new \RuntimeException("Le contenu de l'item dépasse la limite de 1000 caractères.");
        }

        // Vérifie que le contenu est renseigné
        if($item->getContent() == "" || $item->getContent() == null) {
            throw new \RuntimeException("L'item ne possède pas de contenu");
        }

        // Vérifie la date de création
        $createdAt = $item->getCreationDate();
        if ($createdAt === null) {
            throw new \RuntimeException("La date de création de l'item n'est pas renseignée.");
        }

        foreach ($this->item as $existingItem) {
            $existingCreatedAt = $existingItem->getCreationDate();
            
            if ($existingCreatedAt !== null) {
                $interval = $existingCreatedAt->diff($createdAt);
                $minutesDiff = $interval->i + ($interval->h * 60) + ($interval->d * 24 * 60);
                
                if ($minutesDiff < 30) {
                    throw new \RuntimeException("Il faut respecter une période de 30 minutes entre la création de deux items d'une même liste.");
                }
            }
        }

        if (!$this->item->contains($item)) {
            $this->item->add($item);
            // Vérifie si on a atteint le 8ème item et envoyer un mail ToDo
            if ($this->item->count() == 8) {
                $user = new User();
                $user->setEmail("toto@gmail.com");

                $mail = new EmailSenderService();
                $mail->setContent("Il vous reste deux items à ajouter")
                    ->setObject("information item")
                    ->setRecipent($user)
                    ->testSendingEmail();
            }
            $item->setToDo($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->item->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getToDo() === $this) {
                $item->setToDo(null);
            }
        }

        return $this;
    }
    
}
