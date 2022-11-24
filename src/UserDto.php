<?php
namespace App;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
/**
* @Groups({"default", "create", "update"})
* @Assert\NotBlank(groups={"default", "create"})
*/
    public string $email;

    public string $password;

}