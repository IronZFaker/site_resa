<?php

    class Place {
        private $idPlace;
        private $idConcert;
        private $siege;

        // Getters
        function getidPlace() : int {
          return $this->idPlace;
        }

        function getidConcert() : int {
          return $this->idConcert;
        }

        function getSiege() : int {
          return $this->siege;
        }


    }

?>