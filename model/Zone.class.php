<?php

    class Zone {
        private $zone;
        private $tarif;


        // Getters
        function getZone() : int {
          return $this->zone;
        }

        function getTarif() : int {
          return $this->tarif;
        }
    }

?>