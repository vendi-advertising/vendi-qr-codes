<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends AbstractEntityWithUuidAndDateTimeCreated
{
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'clients')]
    private Collection $users;

    #[ORM\OneToMany(targetEntity: Domain::class, mappedBy: 'client')]
    private Collection $domains;

    public function __construct(
        #[ORM\Column(type: "string", length: 255, nullable: false)]
        public readonly string $name,
        array $domains = [],
    ) {
        parent::__construct();
        $this->users = new ArrayCollection();
        $this->domains = new ArrayCollection($domains);

    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addClient($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeClient($this);
        }

        return $this;
    }

    public function getDomains(): Collection
    {
        return $this->domains;
    }

    public function addDomain(Domain $domain): static
    {
        if (!$this->domains->contains($domain)) {
            $this->domains->add($domain);
            $domain->setClient($this);
        }

        return $this;
    }

    public function removeDomain(Domain $domain): static
    {
        if ($this->domains->removeElement($domain)) {
            // set the owning side to null (unless already changed)
            if ($domain->getClient() === $this) {
                $domain->setClient(null);
            }
        }

        return $this;
    }
}
