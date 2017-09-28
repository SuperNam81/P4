<?php

namespace P4\BilletterieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Booking
 *
 * @ORM\Table(name="p4_booking")
 * @ORM\Entity(repositoryClass="P4\BilletterieBundle\Repository\BookingRepository")
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
     * @var \DateTime
     *
     * @ORM\Column(name="bookingDate", type="datetime")
     */
    private $bookingDate;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity="P4\BilletterieBundle\Entity\Visitor", cascade={"persist"})
     */
    private $visitors;


    public function __construct()
    {
        $this->bookingDate         = new \Datetime();
        //$this->visitors   = new ArrayCollection();
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
     * @param \DateTime $bookingDate
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
     * @return \DateTime
     */
    public function getBookingDate()
    {
        return $this->bookingDate;
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
     * Visitor $visitor
     
    public function addVisitor(Visitor $visitor)
    {
        $this->visitors[] = $visitor;
    }

    /**
     * @param Visitor $visitor
     
    public function removeVisitor(Visitor $visitor)
    {
        $this->visitors->removeElement($visitor);
    }

    /**
     * Get visitor
     *
     * @return ArrayCollection
     
    public function getVisitors()
    {
        return $this->visitors;
    }*/

    /**
     * Set visitors
     *
     * @param \P4\BilletterieBundle\Entity\Visitor $visitors
     *
     * @return Booking
     */
    public function setVisitors(\P4\BilletterieBundle\Entity\Visitor $visitors = null)
    {
        $this->visitors = $visitors;

        return $this;
    }

    /**
     * Get visitors
     *
     * @return \P4\BilletterieBundle\Entity\Visitor
     */
    public function getVisitors()
    {
        return $this->visitors;
    }
}
