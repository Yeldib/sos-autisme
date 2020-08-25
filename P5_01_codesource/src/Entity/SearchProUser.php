<?php

namespace App\Entity;

class SearchProUser
{

   private $jobCategory;

   private $department;
   
   /**
    * Get the value of jobCategory
    */ 
   public function getJobCategory()
   {
      return $this->jobCategory;
   }

   /**
    * Set the value of jobCategory
    *
    * @return  self
    */ 
   public function setJobCategory($jobCategory)
   {
      $this->jobCategory = $jobCategory;

      return $this;
   }

   /**
    * Get the value of department
    */ 
   public function getDepartment()
   {
      return $this->department;
   }

   /**
    * Set the value of department
    *
    * @return  self
    */ 
   public function setDepartment($department)
   {
      $this->department = $department;

      return $this;
   }
}