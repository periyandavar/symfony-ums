<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as Validate;

/**
 * @ORM\Entity
 * @ORM\Table(name = "task")
 * @Assert\GroupSequence({"Task", "register"})
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(groups={"register"})
     * @Validate\ContainsAlphanumeric(groups={"register"})
     */
    protected $task;
    /**
     * @ORM\Column(type="datetime")
     * @Assert\Sequentially({
     *      @Assert\NotBlank,
     *      @Assert\Type(type="\DateTime")
     * }, groups={"register"})
     */
    protected $dueDate;

    public function getTask()
    {
        return $this->task;
    }

    public function setTask(string $task)
    {
        $this->task = $task;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTime $dueDate)
    {
        $this->dueDate = $dueDate;
    }

    /**
     * Get the value of id.
     */
    public function getId()
    {
        return $this->id;
    }

    public function getWebPath()
    {
        return "img/symfony.png";
    }
}
