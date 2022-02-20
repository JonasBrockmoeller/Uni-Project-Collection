package com.example.gui;

import TrafficLight.BehaviourImplementations.Car.ArrowLight;
import TrafficLight.BehaviourImplementations.Car.DutchCar;
import TrafficLight.BehaviourImplementations.Car.GermanCar;
import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.Crossing;
import TrafficLight.Entities.ILight;
import TrafficLight.Enum.Color;
import TrafficLight.Enum.Direction;
import TrafficLight.Factory.CarLightFactory;
import TrafficLight.Factory.CrossingFactory;
import TrafficLight.UIOberserver.UIObserver;
import javafx.concurrent.Task;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.shape.Circle;

import java.io.IOException;
import java.net.MalformedURLException;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.Arrays;

public class LeftTurnController implements UIObserver {
    @FXML
    public Circle NGREEN;
    @FXML
    public Circle NYELOW;
    @FXML
    public Circle NRED;
    @FXML
    public Circle NLEFTGO;
    @FXML
    public Circle NLEFTSTOP;
    @FXML
    public Circle SLEFTGO;
    @FXML
    public Circle SLEFTSTOP;
    @FXML
    public Circle SGREEN;
    @FXML
    public Circle SYELLOW;
    @FXML
    public Circle SRED;
    @FXML
    public Circle WYELLOW;
    @FXML
    public Circle WRED;
    @FXML
    public Circle WGREEN;
    @FXML
    public Circle OYELLOW;
    @FXML
    public Circle ORED;
    @FXML
    public Circle OGREEN;
    @FXML
    public Button home = new Button();
    @FXML
    public Button emergency = new Button();
    @FXML
    public Button nightmode = new Button();
    @FXML
    public Button start = new Button();
    @FXML
    public Button stop = new Button();
    @FXML
    private ImageView backgroundImage;

    private CarLight carLNS;
    private CarLight carLEW;
    private CarLight carLTurnsNS;
    private Crossing simpleCrossing;
    private Thread getItemsThread;
    private CarLightFactory cFactory = new CarLightFactory();
    private CrossingFactory crossingFactory = new CrossingFactory();

    public LeftTurnController() {
        carLNS = cFactory.createDutch(Direction.NORTH_SOUTH);
        carLEW = cFactory.createDutch(Direction.EAST_WEST);
        carLTurnsNS = cFactory.createDutch(Direction.LEFT_TURN);
        carLTurnsNS.setLightBehaviour(new ArrowLight());

        carLNS.registerUIObserver(this);
        carLEW.registerUIObserver(this);
        carLTurnsNS.registerUIObserver(this);

        simpleCrossing = crossingFactory.createFourWayCrossingWithTurns(carLEW, carLNS, carLTurnsNS);

        //Use this codeblock if javafx does not update properly
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                simpleCrossing.start();
                return null;
            }
        };
        getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(true);
    }

    @FXML
    private void goHome() throws IOException {
        if(getItemsThread != null) getItemsThread.stop();
        Application.setRoot("MainApp");
    }

    @FXML
    public void start() {
        if(getItemsThread != null) getItemsThread.stop();
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                simpleCrossing.start();
                return null;
            }
        };
        getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(false);
        getItemsThread.start();
    }

    @FXML
    public void setEmergency() {
        if(getItemsThread != null) getItemsThread.stop();
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                try {
                    simpleCrossing.emergency();
                } catch(Exception e){
                    e.printStackTrace();
                }
                return null;
            }
        };
        getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(true);
        getItemsThread.start();
    }

    @FXML
    public void setNightmode() {
        if(getItemsThread != null) getItemsThread.stop();
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                simpleCrossing.nightmode();
                return null;
            }
        };
        getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(true);
        getItemsThread.start();
    }

    @FXML
    public void setGermanBehaviour() {
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                carLNS.setLightBehaviour(new GermanCar());
                carLEW.setLightBehaviour(new GermanCar());
                carLTurnsNS.setLightBehaviour(new ArrowLight());
                return null;
            }
        };
        getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(true);
        getItemsThread.start();

    }

    @FXML
    public void setDutchBehaviour() {
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                carLNS.setLightBehaviour(new DutchCar());
                carLEW.setLightBehaviour(new DutchCar());
                carLTurnsNS.setLightBehaviour(new ArrowLight());
                return null;
            }
        };
        getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(true);
        getItemsThread.start();

    }

    @Override
    public void update(ILight light, Color toShow) {
        if(light.equals(carLNS)){
            this.carLightsNSOff();
            this.updateCarLightsNS(toShow);
        }
        if(light.equals(carLEW)){
            this.carLightsEWOff();
            this.updateCarLightsEW(toShow);
        }
        if(light.equals(carLTurnsNS)){
            this.carLightsLeftTurnOff();
            this.updateCarLightsLeftTurn(toShow);
        }
        try {
            Thread.sleep(1000);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
    }

    private void updateCarLightsEW(Color toShow) {
        if(toShow.equals(Color.RED)){
            setColor(toShow.getColor()[0], WRED, ORED);
            this.setImage("GUI/src/main/resources/com/example/gui/Images/4waycrossing.png");
        } else if(toShow.equals(Color.YELLOW)){
            setColor(toShow.getColor()[0], WYELLOW, OYELLOW);
            this.setImage("GUI/src/main/resources/com/example/gui/Images/4waycrossing.png");
        } else if(toShow.equals(Color.RED_YELLOW)){
            setColor(toShow.getColor()[0], WRED, ORED);
            setColor(toShow.getColor()[1], WYELLOW, OYELLOW);
            this.setImage("GUI/src/main/resources/com/example/gui/Images/4waycrossing.png");
        } else if(toShow.equals(Color.GREEN)){
            setColor(toShow.getColor()[0], WGREEN, OGREEN);
            this.setImage("GUI/src/main/resources/com/example/gui/Images/4waycrossingWITHLEFTTURNSTRIAGHTHORIZONTAL.png");
        }
    }

    private void updateCarLightsLeftTurn(Color toShow) {
        if(toShow.equals(Color.RED)){
            setColor(toShow.getColor()[0], NLEFTSTOP, SLEFTSTOP);
            this.setImage("GUI/src/main/resources/com/example/gui/Images/4waycrossing.png");
        } else if(toShow.equals(Color.GREEN)){
            setColor(toShow.getColor()[0], NLEFTGO, SLEFTGO);
            this.setImage("GUI/src/main/resources/com/example/gui/Images/4waycrossingWITHLEFTTURNTURNING.png");
        }
    }

    private void updateCarLightsNS(Color toShow) {
        if(toShow.equals(Color.RED)){
            setColor(toShow.getColor()[0], NRED, SRED);
            this.setImage("GUI/src/main/resources/com/example/gui/Images/4waycrossing.png");
        } else if(toShow.equals(Color.YELLOW)){
            setColor(toShow.getColor()[0], NYELOW, SYELLOW);
            this.setImage("GUI/src/main/resources/com/example/gui/Images/4waycrossing.png");
        } else if(toShow.equals(Color.RED_YELLOW)){
            setColor(toShow.getColor()[0], NRED, SRED);
            setColor(toShow.getColor()[1], NYELOW, SYELLOW);
            this.setImage("GUI/src/main/resources/com/example/gui/Images/4waycrossing.png");
        } else if(toShow.equals(Color.GREEN)){
            setColor(toShow.getColor()[0], NGREEN, SGREEN);
            this.setImage("GUI/src/main/resources/com/example/gui/Images/4waycrossingWITHLEFTTURNSTRIAGHT.png");
        }
    }

    private void carLightsNSOff() {
        var colorOff = Color.OFF.getColor()[0];
        setColor(colorOff, NRED, NYELOW, NGREEN, SRED, SYELLOW, SGREEN);
    }

    private void carLightsEWOff() {
        var colorOff = Color.OFF.getColor()[0];
        setColor(colorOff, ORED, OYELLOW, OGREEN, WRED, WYELLOW, WGREEN);
    }

    private void carLightsLeftTurnOff() {
        var colorOff = Color.OFF.getColor()[0];
        setColor(colorOff, NLEFTGO, NLEFTSTOP,SLEFTGO, SLEFTSTOP);
    }

    private void setImage(String path){
        Path imageFile = Paths.get(path);
        try {
            backgroundImage.setImage(new Image(imageFile.toUri().toURL().toExternalForm()));
        } catch (MalformedURLException e) {
            System.out.println(e.getMessage());
        }
    }

    private void setColor(String colors, Circle ... circles){
        Arrays.stream(circles).forEach(e -> {
            e.setFill(javafx.scene.paint.Color.valueOf(colors));
        });
    }
}
