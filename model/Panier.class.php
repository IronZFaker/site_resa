<?php

    class Panier {
        private $idClient;
        private $idPlace;
        private $timeExp;

        // Getters
        function getidClient() : int {
          return $this->idClient;
        }

        function getidPlace() : int {
          return $this->idPlace;
        }

        function getTimeExp() : int {
          return $this->timeExp;
        }


    }

?>