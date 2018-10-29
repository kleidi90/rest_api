<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Jobs
 *
 * @ORM\Table(name="jobs", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Job
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="job_title", type="string", length=150, nullable=false)
     *
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "The title must be at least {{ limit }} characters long",
     *      maxMessage = "The title cannot be longer than {{ limit }} characters"
     * )
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="job_zipcode", type="integer", nullable=false)
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="job_city", type="string", length=50, nullable=false)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="job_description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="job_execution_date", type="datetime", nullable=false)
     */
    private $executionDate = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="job_service_id", type="integer", nullable=false)
     *
     */
    private $serviceId;

    /**
     * @var DateTime
     */
    private $created_at;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return DateTime
     */
    public function getExecutionDate()
    {
        return $this->executionDate;
    }

    /**
     * @param $executionDate
     */
    public function setExecutionDate($executionDate)
    {
        $this->executionDate = $executionDate;
    }



    /**
     * @return string
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * @param $executionDate
     */
    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;
    }

}

