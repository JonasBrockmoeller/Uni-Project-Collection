package com.example.gui;

import TrafficLight.BehaviourImplementations.Car.DutchCar;
import TrafficLight.BehaviourImplementations.Car.GermanCar;
import TrafficLight.UIOberserver.UIObserver;
import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.Crossing;
import TrafficLight.Entities.ILight;
import TrafficLight.Enum.Color;
import TrafficLight.Enum.Direction;
import TrafficLight.Factory.CarLightFactory;
import TrafficLight.Factory.CrossingFactory;
import javafx.concurrent.Task;
import javafx.fxml.FXML;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.shape.Circle;

import java.io.IOException;
import java.net.MalformedURLException;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.Arrays;

public class FourWayCrossingWithoutPedestrian implements UIObserver {

    @FXML
    public Circle NGREEN;
    @FXML
    public Circle NYELOW;
    @FXML
    public Circle NRED;
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
    public Circle OGREEN;
    @FXML
    public Circle ORED;
    @FXML
    public ImageView backgroundImage;

    private CarLightFactory cFactory = new CarLightFactory();
    private CrossingFactory crossingFactory = new CrossingFactory();
    private CarLight carLightEW;
    private CarLight carLightNS;
    private Crossing crossing;
    private Thread getItemsThread;

    public FourWayCrossingWithoutPedestrian() {
        carLightEW = cFactory.createDutch(Direction.EAST_WEST);
        carLightNS = cFactory.createDutch(Direction.NORTH_SOUTH);
        carLightEW.registerUIObserver(this);
        carLightNS.registerUIObserver(this);

        crossing = crossingFactory.createFourWayCrossingWithoutPedestrian(carLightEW, carLightNS);

        //This code block is used, so that javafx updates properly:
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                crossing.start();
                return null;
            }
        };

        getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(true);
    }

    @FXML
    private void start() {
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                crossing.request();
                return null;
            }
        };
        getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(false);
        getItemsThread.start();
    }


    @FXML
    private void goHome() throws IOException {
        if(getItemsThread != null) getItemsThread.stop();
        Application.setRoot("MainApp");
    }

    @FXML
    private void setGermanBehaviour() {
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                carLightNS.setLightBehaviour(new GermanCar());
                carLightEW.setLightBehaviour(new GermanCar());
                return null;
            }
        };
        getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(true);
        getItemsThread.start();

    }

    @FXML
    private void setDutchBehaviour()  {
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                carLightNS.setLightBehaviour(new DutchCar());
                carLightEW.setLightBehaviour(new DutchCar());
                return null;
            }
        };
        getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(true);
        getItemsThread.start();

    }

    @FXML
    private void setEmergency()  {
        if(getItemsThread != null) getItemsThread.stop();
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() {
                try {
                    crossing.emergency();
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
    private void setNightmode() {
        if(getItemsThread != null)
            getItemsThread.stop();
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                crossing.nightmode();
                return null;
            }
        };
        getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(true);
        getItemsThread.start();
    }

    @Override
    public void update(ILight light, Color toShow) {
        if(light.equals(carLightEW)){
            this.lightsNSOff();
            this.updateCarLightsNS(toShow);
        }
        if(light.equals(carLightNS)){
            this.lightsEWOff();
            this.updateCarLightsEW(toShow);
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
            this.setImage("GUI/src/main/resources/com/example/gui/Images/4waycrossingEW.png");
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
            this.setImage("GUI/src/main/resources/com/example/gui/Images/4waycrossingNS.png");
        }
    }

    private void lightsEWOff() {
        setColor(Color.OFF.getColor()[0], WYELLOW, WRED, WGREEN, OYELLOW, OGREEN, ORED);
    }

    private void lightsNSOff() {
        setColor(Color.OFF.getColor()[0], NGREEN, NYELOW, NRED, SGREEN, SYELLOW, SRED);
    }

    private void setImage(String path){
        Path imageFile = Paths.get(path);
        try {
            backgroundImage.setImage(new Image(imageFile.toUri().toURL().toExternalForm()));
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
    }

    private void setColor(String color, Circle ... circles){
        Arrays.stream(circles).forEach(e -> {
            e.setFill(javafx.scene.paint.Color.valueOf(color));
        });
    }
}
