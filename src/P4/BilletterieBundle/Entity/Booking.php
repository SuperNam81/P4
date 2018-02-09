<?php

namespace P4\BilletterieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Booking
 *
 * @ORM\Table(name="p4_booking")
 * @ORM\Entity(repositoryClass="P4\BilletterieBundle\Repository\BookingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Booking
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
     * @var \Date
     *
     * @ORM\Column(name="bookingDate", type="string", length=255)
     * @Assert\Type("string")     
     */
    private $bookingDate;

    /**
     * @ORM\OneToMany(targetEntity="P4\BilletterieBundle\Entity\Visitor", mappedBy="booking", cascade={"persist"})
     * @Assert\NotNull()
     * @Assert\Valid(traverse=true)
     */
    private $visitors;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email(message = "Email non valide")
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="ticket", type="boolean")
     * @Assert\Type("bool")
     */
    private $ticket;
        

    public function __construct()
    {
        $this->visitors = new ArrayCollection();
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
     * Set bookingDate
     *
     * @param string $bookingDate
     *
     * @return Booking
     */
    public function setBookingDate($bookingDate)
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }

    /**
     * Get bookingDate
     *
     * @return string
     */
    public function getBookingDate()
    {
        return $this->bookingDate;
    }

    /**
     * @param Visitor $visitor
     */
    public function addVisitor(Visitor $visitor)
    {
        $this->visitors[] = $visitor;
        // On lie le visiteur à la réservation
        $visitor->setBooking($this);
    }

    /**
     * @param Visitor $visitor
     */
    public function removeVisitor(Visitor $visitor)
    {
        $this->visitors->removeElement($visitor);
    }

    /**
     * Get visitor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVisitors()
    {
        return $this->visitors;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Booking
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
     * Set ticket
     *
     * @param boolean $ticket
     *
     * @return Visitor
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return bool
     */
    public function getTicket()
    {
        return $this->ticket;
    }
}
