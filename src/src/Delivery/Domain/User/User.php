<?php

namespace KsK\Delivery\Domain\User;


use KsK\Delivery\Domain\Shared\BaseModel;
use KsK\Shared\Domain\Service\PasswordHasherInterface;
use KsK\Shared\Domain\ValueObject\Uuid;
use Symfony\Component\Security\Delivery\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Delivery\User\UserInterface;


class User extends BaseModel implements UserInterface, PasswordAuthenticatedUserInterface
{
    protected UserId $id;
    protected array $roles;

    public function __construct(

        protected string     $email,
        private ?string     $plainPassword,
        private ?string    $password,
        private string     $username,
        private string     $name,
        private ?string    $lastName,
        private bool       $enabled,
        private ?\DateTime $lastActivityAt,
        private ?\DateTime $updatedLastLogin


    )
    {
        $id = Uuid::random();
        $this->id = new UserId($id);
        $this->roles[] = Role::ROLE_USER;

    }

    public static function create(
        string $email,
        string $plainPassword,
        string $username,
        string $name,
        string $lastName = null,
        ): User
    {


        $user = new self(
            $email,
            $plainPassword,
            null,
            $username,
            $name,
            $lastName,
            true,
            null,
            null,
        );
        $user->registerEvent(new UserWasCreated($user->id->value(), $user->email));
        return $user;
    }

    public static function signUp(string $email, string $username, string $plainPassword, string $name): User
    {

        return self::create($email, $plainPassword, $username, $name, null, null);

    }

    public function update(?string $name = null, ?string $lastname = null): void
    {
        $this->name = $name ?? $this->name;
        $this->lastName = $lastname ?? $this->lastName;

    }

    public function encodePassword(PasswordHasherInterface $passwordHasher): self
    {
        $hashedPassword = $passwordHasher->hashPassword($this, $this->getPlainPassword());
        $this->password = $hashedPassword;
        return $this;
    }

    public function setAsAdmin():void
    {

        $this->roles[] = Role::ROLE_SUPER_ADMIN;
    }

    public function userLogged():void
    {
        $this->lastActivityAt = new \DateTime();
        $this->updatedLastLogin = new \DateTime();
    }

    /**
     * @return UserId
     */
    public function getId(): UserId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }



    /**
     * @return \DateTime
     */
    public function getLastActivityAt(): \DateTime
    {
        return $this->lastActivityAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedLastLogin(): \DateTime
    {
        return $this->updatedLastLogin;
    }


    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = Role::ROLE_USER;
        return array_unique($roles);
    }


    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername(): string
    {
        return $this->username;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
