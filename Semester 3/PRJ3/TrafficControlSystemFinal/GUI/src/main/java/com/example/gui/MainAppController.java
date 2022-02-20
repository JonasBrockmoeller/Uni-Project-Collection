package com.example.gui;

import javafx.fxml.FXML;

import java.io.IOException;

public class MainAppController {

    @FXML
    private void switchtoSingleCrossing() throws IOException {
        Application.setRoot("SingleCrossingWithPedestrian");
    }
    @FXML
    private void switchToFourWayCrossingWithoutPedestrian() throws IOException {
        Application.setRoot("FourWayCrossingWithoutPedestrian");

    }
    @FXML
    private void switchToLeftTurnCrossing() throws IOException {
        Application.setRoot("FourWayCrossingWithLeftTurn");
    }
    @FXML
    private void schwitchToSingleCarLight() throws IOException {
        Application.setRoot("SingleTrafficLightGUI");
    }
    @FXML
    private void schwitchToSinglePedestrianLight() throws IOException {
        Application.setRoot("PedestrianLightGUI");
    }
}