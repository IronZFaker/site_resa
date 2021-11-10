<?php
    class Place {
        private $idPlace;
        private $idConcert;
        private $dispo;
        private $numSiege;

        // Getters
        function getidPlace() : int {
          return $this->idPlace;
        }
        function getDispo() : bool {
          return $this->dispo;
        }

        function getidConcert() : int {
          return $this->idConcert;
        }

        function getSiege() : int {
          return $this->numSiege;
        }


    }

?>
