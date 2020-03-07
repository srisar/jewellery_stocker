<?php

namespace Jman\Models;

class User
{

    /** @var int */
    private $id;
    /** @var string */
    private $username;
    /** @var string */
    private $first_name;
    /** @var string */
    private $last_name;
    /** @var string */
    private $password_string;
    /** @var string */
    private $password;
    /** @var string */
    private $created_at;
    /** @var string */
    private $updated_at;


    const TYPE_ADMIN = 1;
    const TYPE_USER = 2;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return User
     */
    public function setLastName(string $last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string
     */
    public function getPasswordString(): ?string
    {
        return $this->password_string;
    }

    /**
     * @param string $password_string
     */
    public function setPasswordString(string $password_string)
    {
        $this->password_string = $password_string;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }


    /**
     * @return string
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }


    public function getFullName(): ?string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Generate a password hash from the password text to store it in a database
     * @return bool|string
     */
    public function generatePasswordString()
    {
        return password_hash($this->getPassword(), PASSWORD_DEFAULT);
    }


}