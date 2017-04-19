<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Bill
 *
 * @ORM\Table(name="bill")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BillRepository")
 */
class Bill
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_booking", type="datetime")
     */
    private $dateOfBooking;

    /**
     * @var string
     *
     * @ORM\Column(name="ticket_type", type="string", length=12)
     * @Assert\Choice(
     *  choices = {"allJourney", "halfJourney"}   
     * )
     */
    private $ticketType;

    /**
     * @var int
     *
     * @ORM\Column(name="number_of_tickets", type="integer")
     */
     private $numberOfTickets;

    /**
     * @var int
     *
     * @ORM\Column(name="order_id", type="integer", unique=true)
     */
    private $orderId;

    /**
     * @var int
     *
     * @ORM\Column(name="total_price", type="integer")
     */
    private $totalPrice;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Bill
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Bill
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Bill
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set dateOfBooking
     *
     * @param \DateTime $dateOfBooking
     *
     * @return Bill
     */
    public function setDateOfBooking($dateOfBooking)
    {
        $this->dateOfBooking = $dateOfBooking;

        return $this;
    }

    /**
     * Get dateOfBooking
     *
     * @return \DateTime
     */
    public function getDateOfBooking()
    {
        return $this->dateOfBooking;
    }

    /**
     * Set ticketType
     *
     * @param string $ticketType
     *
     * @return Bill
     */
    public function setTicketType($ticketType)
    {
        $this->ticketType = $ticketType;

        return $this;
    }

    /**
     * Get ticketType
     *
     * @return string
     */
    public function getTicketType()
    {
        return $this->ticketType;
    }
    /**
     * Set numberOfTickets
     *
     * @param string $numberOfTickets
     *
     * @return Bill
     */
    public function setNumberOfTickets($numberOfTickets)
    {
        $this->numberOfTickets = $numberOfTickets;

        return $this;
    }

    /**
     * Get numberOfTickets
     *
     * @return string
     */
    public function getNumberOfTickets()
    {
        return $this->numberOfTickets;
    }
    /**
     * Set orderId
     *
     * @param integer $orderId
     *
     * @return Bill
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set totalPrice
     *
     * @param integer $totalPrice
     *
     * @return Bill
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return int
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->setCreatedAt(new \DateTime("now"));
        //À voir pour unique
        $this->setOrderId(random_int(1, 10));
    }
    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->setUpdatedAt(new \DateTime("now"));
    }
}

