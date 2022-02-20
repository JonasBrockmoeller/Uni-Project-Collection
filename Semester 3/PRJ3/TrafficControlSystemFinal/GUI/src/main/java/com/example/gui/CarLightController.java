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
import javafx.scene.control.Button;
import javafx.scene.shape.Circle;

import java.io.IOException;
import java.util.Arrays;

public class CarLightController implements UIObserver{

    public Button start = new Button();
    public Button stop = new Button();
    public Button Emergency = new Button();
    public Button setDutch = new Button();
    public Button Nightmode = new Button();
    public Button setGerman = new Button();
    public Button Home = new Button();
    public Circle Red = new Circle();
    public Circle Yellow = new Circle();
    public Circle Green = new Circle();
    private Thread getItemsThread;
    private CarLightFactory cFactory = new CarLightFactory();
    private CarLight light;
    private CrossingFactory crossingFactory = new CrossingFactory();
    private Crossing simpleCrossing;

    public CarLightController(){
        light = cFactory.createDutch(Direction.EAST_WEST);
        light.registerUIObserver(this);

        simpleCrossing = crossingFactory.createCarLightCrossing(light);
    }
    @FXML
    public void start() {
        //Use this codebook if javafx does not update properly
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                simpleCrossing.request();
                return null;
            }
        };
        getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(false);
        getItemsThread.start();
    }

    @FXML
    public void stop() {
        //Use this codebook if javafx does not update properlya
        if(getItemsThread != null) getItemsThread.stop();
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                simpleCrossing.start();
                return null;
            }
        };
        getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(true);
        getItemsThread.start();
    }

    @FXML
    public void setEmergency() {
        if(getItemsThread != null) getItemsThread.stop();
        //Use this codebook if javafx does not update properly
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                simpleCrossing.emergency();
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
        //Use this codebook if javafx does not update properly
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
    public void setDutchBehaviour() {
        light.setLightBehaviour(new DutchCar());
    }

    @FXML
    public void setGermanBehaviour() {
        light.setLightBehaviour(new GermanCar());
    }

    @FXML
    public void goHome() throws IOException {
        if(getItemsThread != null) getItemsThread.stop();
        Application.setRoot("MainApp");
    }

    @Override
    public void update(ILight light, Color toShow) {
        if(light.getClass().equals(CarLight.class)){
            this.carLightsOff();
            this.updateCarLights(toShow);
        }
        try {
            Thread.sleep(1000);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
    }

    private void carLightsOff() {
        var colorOff = Color.OFF.getColor()[0];
        setColor(colorOff, Green, Yellow, Red);
    }
    private void setColor(String colors, Circle ... circles){
        Arrays.stream(circles).forEach(e -> {
            e.setFill(javafx.scene.paint.Color.valueOf(colors));
        });
    }

    private void updateCarLights(Color toShow) {
        if(toShow.equals(Color.RED)){
            setColor(toShow.getColor()[0], Red);
        } else if(toShow.equals(Color.YELLOW)){
            setColor(toShow.getColor()[0], Yellow);
        } else if(toShow.equals(Color.RED_YELLOW)){
            setColor(toShow.getColor()[1], Yellow);
            setColor(toShow.getColor()[0], Red);
        } else if(toShow.equals(Color.GREEN)){
            setColor(toShow.getColor()[0], Green);
        }
    }
}
