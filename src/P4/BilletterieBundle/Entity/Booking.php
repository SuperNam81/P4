<?php

namespace P4\BilletterieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\OneToOne(targetEntity="P4\BilletterieBundle\Entity\Visitor", cascade={"persist"})
     */
    private $visitor;


    public function __construct()
    {
        $this->bookingDate         = new \Datetime();
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
     * Set visitor
     *
     * @param \P4\BilletterieBundle\Entity\Visitor $visitor
     *
     * @return Booking
     */
    public function setVisitor(\P4\BilletterieBundle\Entity\Visitor $visitor = null)
    {
        $this->visitor = $visitor;

        return $this;
    }

    /**
     * Get visitor
     *
     * @return \P4\BilletterieBundle\Entity\Visitor
     */
    public function getVisitor()
    {
        return $this->visitor;
    }
}
