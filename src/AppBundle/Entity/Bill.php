<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as BillAssert;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Ticket;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
/**
 * Bill
 *
 * @ORM\Table(name="bill")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BillRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Bill
{
    const TYPE_ALL_JOURNEY = "allJourney";
    const TYPE_HALF_JOURNEY = "halfJourney";
    const TYPE_TICKET_TYPE_ARRAY = [
        'form.billStep1.allJourney'   => self::TYPE_ALL_JOURNEY,
        'form.billStep1.halfJourney'   => self::TYPE_HALF_JOURNEY
    ];
    const HOUR_APPLY_HALF_JOURNEY_AFTER = 14;
    const HOUR_END_OF_THE_DAY = 18;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     * @ORM\Column(name="order_id", type="guid")
     */
    private $orderId;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     * @Assert\NotBlank(groups={"step1Bill"})
     * @Assert\Email(
     *  checkMX = true,
     *  groups={"step1Bill"}
     * )

     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_booking", type="datetime")
     * @Assert\NotBlank(groups={"step1Bill"})
     * @Assert\DateTime(groups={"step1Bill"})
     * @Assert\GreaterThanOrEqual("today",groups={"step1Bill"})
     * @Assert\LessThan("today +1 years",groups={"step1Bill"})
     * @BillAssert\ValidDateOfBooking(message="bill.dateOfBooking.validDateOfBooking",groups={"step1Bill"})
     *
     */
    private $dateOfBooking;

    /**
     * @var string
     *
     * @ORM\Column(name="ticket_type", type="string", length=12)
     * @Assert\NotBlank(groups={"step1Bill"})
     * @Assert\Choice(
     *  choices = {Bill::TYPE_ALL_JOURNEY, Bill::TYPE_HALF_JOURNEY},
     *  strict = true,
     *  groups={"step1Bill"}
     * )
     * @BillAssert\ValidTicketType(message="bill.ticketType.validTicketType",groups={"step1Bill"})
     */
    private $ticketType;

    /**
     * @var string
     *
     * @ORM\Column(name="stripe_id", type="string")
     *
     */
    private $stripeId;

    /**
     * @var int
     *
     * @ORM\Column(name="number_of_tickets", type="integer")
     * @Assert\NotBlank(groups={"step1Bill"})
     * @Assert\GreaterThanOrEqual(1,groups={"step1Bill"})
     * @Assert\LessThanOrEqual(1000,groups={"step1Bill"})
     * @BillAssert\ValidNumberOfTickets(message="bill.numberOfTickets.validTicketsAvailable",groups={"step1Bill"})
     */
    private $numberOfTickets = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="total_price", type="integer")
     * @Assert\NotBlank(groups={"step3Bill"})
     * @Assert\GreaterThanOrEqual(0,groups={"step3Bill"})
     */
    private $totalPrice;

    /**
    * @var ArrayCollection
    * @ORM\OneToMany(targetEntity="Ticket", mappedBy="bill", orphanRemoval=true, cascade="persist")
    * @Assert\All({
    *   @Assert\Type(type="AppBundle\Entity\Ticket")
    * },groups={"step2Bill"})
    * @Assert\Valid
    */
    private $tickets;
    /**
     * @var string
     */
    private $step;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

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
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @return string
     */
    public function setOrderId(){
        try{
            $this->orderId = Uuid::uuid1()->toString();
        }catch (UnsatisfiedDependencyException $e){
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
        return $this;
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
        $this->dateOfBooking = \DateTime::createFromFormat('d/m/Y', $dateOfBooking)->setTime(0,0,0);

        return $this;
    }

    /**
     * Get dateOfBooking
     *
     * @return \String
     */
    public function getDateOfBooking()
    {
        if($this->dateOfBooking === null){
            return null;
        }
        return $this->dateOfBooking->format('d/m/Y');
    }
    /**
     * Get dateOfBooking
     *
     * @return \DateTime
     */
    public function getDateOfBookingObject()
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
     * Set tickets
     *
     * @param string $tickets
     *
     * @return Bill
     */
    public function setTickets($tickets)
    {
        //Si array créer un arraycollection de tickets
        if(is_array($tickets)){
            $this->tickets = new ArrayCollection();            
            foreach($tickets as $ticket){
                $newTicket = new Ticket();
                $newTicket->setFirstname($ticket['firstname']);
                $this->tickets->add($newTicket);
            }
            return $this;
        }
        $this->tickets = $tickets;

        return $this;
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
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
     * Get stripeId
     *
     * @return string
     */
    public function getStripeId()
    {
        return $this->stripeId;
    }

    /**
     * Set stripeId
     *
     * @param int $stripeId
     *
     * @return Bill
     */
    public function setStripeId($stripeId)
    {
        $this->stripeId = $stripeId;

        return $this;
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
    public function removeTicket($key){
        $this->tickets->remove($key);
        $this->setNumberOfTickets($this->getNumberOfTickets()-1);
        return $this;
    }

    /**
     * @return string
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param string $step
     */
    public function setStep(string $step)
    {
        $this->step = $step;
    }

    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->setCreatedAt(new \DateTime("now"));
        $this->setOrderId();
    }

    /**
     * Add ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     *
     * @return Bill
     */
    public function addTicket(\AppBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;

        return $this;
    }
    /**
     * Compte les tickets dans bill
     * @return int
     */
    public function countTickets(){
        return count($this->tickets);
    }
}
