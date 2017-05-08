<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CreditCard
 *
 * @ORM\Table(name="credit_card")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CreditCardRepository")
 */
class CreditCard
{
    /**
     * @var string
     *
     * @ORM\Column(name="card_number", type="int")
     * @Assert\NotBlank
     * @Assert\CardScheme(
     *     schemes={"VISA","MASTERCARD"},
     *     message="creditCard.cardNumber.cardScheme"
     * )
     */
    private $cardNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiration_date", type="datetime")
     * @Assert\NotBlank
     * @Assert\DateTime
     * @Assert\GreaterThan("today")
     * @Assert\LesserThan("today + 6 years")
     */
    private $expirationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="security_code", type="int")
     * @Assert\NotBlank
     * @Assert\LesserThan(1000)
     * @Assert\GreaterThan(0)
     */
    private $securityCode;

    public function __construct()
    {
        $this->dateOfBooking = new \DateTime();
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
     * Set cardNumber
     *
     * @param \Int $cardNumber
     *
     * @return Bill
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * Get cardNumber
     *
     * @return \Int
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * Set expirationDate
     *
     * @param \DateTime $expirationDate
     *
     * @return Bill
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Get expirationDate
     *
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set securityCode
     *
     * @param Int $securityCode
     *
     * @return Bill
     */
    public function setSecurityCode($securityCode)
    {
        $this->securityCode = $securityCode;

        return $this;
    }

    /**
     * Get securityCode
     *
     * @return Int
     */
    public function getSecurityCode()
    {
        return $this->securityCode;
    }
}

