<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as TicketAssert;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TicketRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Ticket
{
    //Constantes de prix du Ticket
    const PRICE_NORMAL      = 16;
    const PRICE_SENIOR      = 12;
    const PRICE_REDUCED     = 10;
    const PRICE_CHILD = 8;
    const PRICE_YOUNG_CHILD = 0;
    const PRICE_REDUCED_DIVIDED_BY = 2;
    const AGE_SENIOR = 60;
    const AGE_CHILD = 12;
    const AGE_YOUNG_CHILD = 4;
    const PRICE_TYPE_NORMAL = 'normal';
    const PRICE_TYPE_SENIOR = 'senior';
    const PRICE_TYPE_REDUCED = 'reduced';
    const PRICE_TYPE_CHILD = 'child';
    const PRICE_TYPE_YOUNG_CHILD = 'young_child';
    const MAX_NUMBER_OF_TICKETS_PER_DAY = 1000;


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
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=50)
     * @Assert\NotBlank(groups={"step2Bill"})
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="step2.nameError",
     *     groups={"step2Bill"}
     * )
     * @Assert\Length(
     *     min = 1,
     *     max = 50,
     *     groups={"step2Bill"}
     * )
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=50)
     * @Assert\NotBlank(groups={"step2Bill"})
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="step2.firstnameError",
     *     groups={"step2Bill"}
     * )
     * @Assert\Length(
     *     min = 1,
     *     max = 50,
     *     groups={"step2Bill"}
     * )
     */
    private $firstname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_birth", type="datetime")
     * @Assert\NotBlank(groups={"step2Bill"})
     * @Assert\DateTime(groups={"step2Bill"})
     * @Assert\LessThanOrEqual("today",groups={"step2Bill"})
     * @Assert\GreaterThan("today - 120 years",groups={"step2Bill"})
     */
    private $dateOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=2)
     * @Assert\NotBlank
     *  choices = {"AF","AL","DZ","AS","AD","AO","AI","AQ","AG","AR","AM","AW","AU","AT","AZ","BS","BH","BD","BB","BY","BE","BZ","BJ","BM","BT","BO","BA","BW","BV","BR","IO","BN","BG","BF","BI","KH","CM","CA","CV","KY","CF","TD","CL","CN","CX","CC","CO","KM","CD","CG","CK","CR","CI","HR","CU","CY","CZ","CS","DK","DJ","DM","DO","TP","EC","EG","SV","GQ","ER","EE","ET","FK","FO","FJ","FI","FR","GF","PF","TF","GA","GM","GE","DE","GH","GI","GB","GR","GL","GD","GP","GU","GT","GN","GW","GY","HT","HM","VA","HN","HK","HU","IS","IN","ID","IR","IQ","IE","IL","IT","JM","JP","JO","KZ","KE","KI","KP","KR","KW","KG","LA","LV","LB","LS","LR","LY","LI","LT","LU","MO","MK","MG","MW","MY","MV","ML","MT","MH","MQ","MR","MU","YT","MX","FM","MD","MC","MN","MS","MA","MZ","MM","NA","NR","NP","NL","AN","NC","NZ","NI","NE","NG","NU","NF","MP","NO","OM","PK","PW","PS","PA","PG","PY","PE","PH","PN","PL","PT","PR","QA","RE","RO","SU","RU","RW","SH","KN","LC","PM","VC","WS","SM","ST","SA","RS","SN","SC","SL","SG","SK","SI","SB","SO","ZA","GS","ES","LK","SD","SR","SJ","SZ","SE","CH","SY","TW","TJ","TZ","TH","TG","TK","TO","TT","TE","TN","TR","TM","TC","TV","UG","UA","AE","GB","US","UM","UY","UZ","VU","VA","VE","VN","VI","VQ","WF","EH","YE","YU","ZR","ZM","ZW"}
     *  strict = true,
     *  groups={"step2Bill"}
     * )
     */
    private $countryCode;

    /**
     * @var bool
     *
     * @ORM\Column(name="reduced_price", type="boolean")
     * @TicketAssert\ValidReducedPrice(groups={"step2Bill"})
     */
    private $reducedPrice;

    /**
     * @var string
     * @ORM\Column(name="price_type", type="string")
     * @Assert\NotBlank(groups={"step3Bill"})
     * @Assert\GreaterThanOrEqual(0,groups={"step3Bill"})
     */
    private $priceType;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Bill", inversedBy="tickets", cascade="persist")
     * @ORM\JoinColumn(name="bill_id", referencedColumnName="id", nullable=false)
     */
    private $bill;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     * @Assert\NotBlank(groups={"step3Bill"})
     * @Assert\GreaterThanOrEqual(0,groups={"step3Bill"})
     */
    private $price;

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
     * @return Ticket
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
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Ticket
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Ticket
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return Ticket
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = \DateTime::createFromFormat('d/m/Y',$dateOfBirth)->setTime(0,0,0);

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \String
     */
    public function getDateOfBirth()
    {
        if($this->dateOfBirth === null){
            return null;
        }
        return $this->dateOfBirth->format('d/m/Y');
    }
    /**
     * Get getDateOfBirthObject
     *
     * @return \DateTime
     */
    public function getDateOfBirthObject()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     *
     * @return Ticket
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set reducedPrice
     *
     * @param boolean $reducedPrice
     *
     * @return Ticket
     */
    public function setReducedPrice($reducedPrice)
    {
        $this->reducedPrice = $reducedPrice;
        //die(dump($this));

        return $this;
    }

    /**
     * Get reducedPrice
     *
     * @return bool
     */
    public function getReducedPrice()
    {
        return $this->reducedPrice;
    }

    /**
     * @return string
     */
    public function getPriceType(): string
    {
        return $this->priceType;
    }

    /**
     * @param string $priceType
     */
    public function setPriceType(string $priceType)
    {
        $this->priceType = $priceType;
    }
    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Ticket
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }
    /**
     * Set bill
     *
     * @param integer $bill
     *
     * @return Ticket
     */
    public function setBill(Bill $bill)
    {
        $this->bill = $bill;

        return $this;
    }

    /**
     * Get bill
     *
     * @return int
     */
    public function getBill()
    {
        return $this->bill;
    }
    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->setCreatedAt(new \DateTime("now"));
    }
}
