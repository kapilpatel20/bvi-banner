<?php

namespace Bvi\BannerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Banner
 *
 * @ORM\Table(name="banner")
 * @ORM\Entity(repositoryClass="Bvi\BannerBundle\Repository\BannerRepository")
 */
class Banner
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
     * @var string
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     */
    protected $title;
    
    
    /**
     * @var string
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    protected $image;
    
    /**
     * @var int
     * @ORM\Column(name="sequence", type="integer")
     */
    protected $sequence = 999;
    
    /**
     * @var string
     * @ORM\Column(name="status", type="string", columnDefinition="ENUM('Active','Inactive')",nullable=false) 
     */
    protected $status;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdat;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedat;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="created_by", type="integer", nullable=false)
     */
    protected $createdby;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_by", type="integer", nullable=true)
     */
    protected $updatedby;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Banner
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Set status
     *
     * @param string $status
     * @return Banner
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdat
     *
     * @param \DateTime $createdat
     * @return Banner
     */
    public function setCreatedat($createdat)
    {
        $this->createdat = $createdat;

        return $this;
    }

    /**
     * Get createdat
     *
     * @return \DateTime 
     */
    public function getCreatedat()
    {
        return $this->createdat->format('Y-m-d H:i:s');
    }

    /**
     * Set updatedat
     *
     * @param \DateTime $updatedat
     * @return Banner
     */
    public function setUpdatedat($updatedat)
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    /**
     * Get updatedat
     *
     * @return \DateTime 
     */
    public function getUpdatedat()
    {
        return $this->updatedat->format('Y-m-d H:i:s');
    }

    /**
     * Set createdby
     *
     * @param integer $createdby
     * @return Banner
     */
    public function setCreatedby($createdby)
    {
        $this->createdby = $createdby;

        return $this;
    }

    /**
     * Get createdby
     *
     * @return integer 
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * Set updatedby
     *
     * @param integer $updatedby
     * @return Banner
     */
    public function setUpdatedby($updatedby)
    {
        $this->updatedby = $updatedby;

        return $this;
    }

    /**
     * Get updatedby
     *
     * @return integer 
     */
    public function getUpdatedby()
    {
        return $this->updatedby;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Banner
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }
    
    protected function getUploadRootDir() {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/uploads/banners/';
    }

    protected function getUploadDir() {

        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/banners';
    }

    public function upload() {

        $this->makeDir();

        // the file property can be empty if the field is not required
        if (null === $this->getImage()) {
            return;
        }

        if (null !== $this->getImage()) {

            // do whatever you want to generate a unique name
            $extention = explode('.', $this->getImage()->getClientOriginalName());

            $path = $extention[0] . '_' . time() . '.' . $extention[1];
            $mimeType = $this->getImage()->getMimeType();
            $this->getImage()->move(
                    $this->getUploadRootDir(), $path
            );
            $this->image = $path;
        }
    }

    protected function getFileDir($image) {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir() . '/' . $image;
    }

    public function makeDir() {

        if (!is_dir(__DIR__ . '/../../../../web/uploads' )) {
            mkdir(__DIR__ . '/../../../../web/uploads' , 0777);
        }
        
        if (!is_dir(__DIR__ . '/../../../../web/uploads/banners'  )) {
            mkdir(__DIR__ . '/../../../../web/banners' , 0777);
        }
    }

    

    /**
     * Set sequence
     *
     * @param integer $sequence
     * @return Banner
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;

        return $this;
    }

    /**
     * Get sequence
     *
     * @return integer 
     */
    public function getSequence()
    {
        return $this->sequence;
    }
}
