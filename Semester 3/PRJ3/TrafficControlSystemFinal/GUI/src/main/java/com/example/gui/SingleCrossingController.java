package com.example.gui;

import TrafficLight.BehaviourImplementations.Car.DutchCar;
import TrafficLight.BehaviourImplementations.Car.GermanCar;
import TrafficLight.BehaviourImplementations.Pedestrian.DutchPedestrian;
import TrafficLight.BehaviourImplementations.Pedestrian.GermanPedestrian;
import TrafficLight.Enum.Mode;
import TrafficLight.UIOberserver.UIObserver;
import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.Crossing;
import TrafficLight.Entities.ILight;
import TrafficLight.Entities.PedestrianLight;
import TrafficLight.Enum.Color;
import TrafficLight.Enum.Direction;
import TrafficLight.Factory.CarLightFactory;
import TrafficLight.Factory.CrossingFactory;
import TrafficLight.Factory.PedestrianLightFactory;
import javafx.concurrent.Task;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.shape.Circle;
import javafx.scene.shape.Line;

import java.io.IOException;
import java.net.MalformedURLException;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.Arrays;

public class SingleCrossingController implements UIObserver {
    @FXML
    private Circle WYELLOW;
    @FXML
    private Circle WRED;
    @FXML
    private Circle WGREEN;
    @FXML
    private Circle OYELLOW;
    @FXML
    private Circle OGREEN;
    @FXML
    private Circle ORED;
    @FXML
    private Circle NSTOP;
    @FXML
    private Circle NGO;
    @FXML
    private Circle SSTOP;
    @FXML
    private Circle SGO;
    @FXML
    private ImageView backgroundImage = new ImageView();
    @FXML
    private Line stopline2 = new Line();
    @FXML
    private Line stopline = new Line();
    private PedestrianLight pedL;
    private CarLight carL;
    private Crossing simpleCrossing;
    private Thread getItemsThread;
    private PedestrianLightFactory pFactory = new PedestrianLightFactory();
    private CarLightFactory cFactory = new CarLightFactory();
    private CrossingFactory crossingFactory = new CrossingFactory();

    public SingleCrossingController() {
        pedL = pFactory.createDutch(Direction.STRAIGHT);
        carL = cFactory.createDutch(Direction.STRAIGHT);
        carL.registerUIObserver(this);
        pedL.registerUIObserver(this);

        simpleCrossing = crossingFactory.createSimpleCrossing(pedL, carL);

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
    private void start() {
        Task stop = new Task<>() {
            @Override
            protected Object call() throws Exception {
                carL.getLightBehaviour().start(carL);
                return null;
            }
        };
        Thread getItemsThread = new Thread(stop);
        getItemsThread.setDaemon(false);
        getItemsThread.start();
    }

    @FXML
    private void stop() {
        if(getItemsThread != null) getItemsThread.stop();
        Task stop = new Task<>() {
            @Override
            protected Object call() throws Exception {
                pedL.getLightBehaviour().stop(pedL);
                carL.getLightBehaviour().stop(carL);
                return null;
            }
        };

        Thread getItemsThread = new Thread(stop);
        getItemsThread.setDaemon(true);
        getItemsThread.start();
        //carLightsOff();
    }

    @FXML
    private void goHome() throws IOException {
        if(getItemsThread != null) getItemsThread.stop();
        Application.setRoot("MainApp");
    }

    @FXML
    private void requestPedGreen()  {
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                simpleCrossing.request();
                //pedL.button();
                return null;
            }
        };

        Thread getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(true);
        getItemsThread.start();
    }

    @FXML
    private void setGermanBehaviour()  {
        Task NightMode = new Task<>() {
            @Override
            protected Object call() throws Exception {
                carL.setLightBehaviour(new GermanCar());
                pedL.setLightBehaviour(new GermanPedestrian());
                return null;
            }
        };

        Thread getItemsThread = new Thread(NightMode);
        getItemsThread.setDaemon(true);
        getItemsThread.start();

    }

    @FXML
    private void setDutchBehaviour()  {
        Task NightMode = new Task<>() {
            @Override
            protected Object call() throws Exception {
                carL.setLightBehaviour(new DutchCar());
                pedL.setLightBehaviour(new DutchPedestrian());
                return null;
            }
        };

        Thread getItemsThread = new Thread(NightMode);
        getItemsThread.setDaemon(true);
        getItemsThread.start();

    }

    @FXML
    private void setEmergency()  {
        if(getItemsThread != null) getItemsThread.stop();
        Task emergency = new Task<>() {
            @Override
            protected Object call() throws Exception {
                simpleCrossing.emergency();
                return null;
            }
        };
        getItemsThread = new Thread(emergency);
        getItemsThread.setDaemon(true);
        getItemsThread.start();
    }

    @FXML
    private void setNightmode()  {
        if(getItemsThread != null) getItemsThread.stop();
        Task emergency = new Task<>() {
            @Override
            protected Object call() throws Exception {
                simpleCrossing.nightmode();
                return null;
            }
        };
        getItemsThread = new Thread(emergency);
        getItemsThread.setDaemon(true);
        getItemsThread.start();

    }

    @Override
    public void update(ILight light, Color toShow) {
        if(light.getClass().equals(CarLight.class)){
            this.carLightsOff();
            this.updateCarLights(toShow);
        }
        if(light.getClass().equals(PedestrianLight.class)){
            this.pedLightsOff();
            this.updatePedestrianLights(toShow);
        }
        try {
            Thread.sleep(1000);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
    }

    private void pedLightsOff() {
        var colorOff = Color.OFF.getColor()[0];
        setColor(colorOff, NSTOP, NGO, SSTOP, SGO);
    }

    private void carLightsOff() {
        var colorOff = Color.OFF.getColor()[0];
        setColor(colorOff, WGREEN, WYELLOW, WRED, OYELLOW, OGREEN, ORED);
    }

    public void updateCarLights(Color toShow){
        if(toShow.equals(Color.RED)){
                setColor(toShow.getColor()[0], WRED, ORED);
                this.setImage("GUI/src/main/resources/com/example/gui/Images/simplecrossing.png");
                this.stopline.setVisible(true);
                this.stopline2.setVisible(true);
            } else if(toShow.equals(Color.YELLOW)){
                setColor(toShow.getColor()[0], WYELLOW, OYELLOW);
                this.setImage("GUI/src/main/resources/com/example/gui/Images/simplecrossing.png");
            } else if(toShow.equals(Color.RED_YELLOW)){
                setColor(toShow.getColor()[1], WYELLOW, OYELLOW);
                setColor(toShow.getColor()[0], WRED, ORED);
                this.setImage("GUI/src/main/resources/com/example/gui/Images/simplecrossing.png");
            } else if(toShow.equals(Color.GREEN)){
                setColor(toShow.getColor()[0], WGREEN, OGREEN);
                this.setImage("GUI/src/main/resources/com/example/gui/Images/cars_simplecrossing.png");
                this.stopline.setVisible(false);
                this.stopline2.setVisible(false);
        }
    }

    public void updatePedestrianLights(Color toShow){
        if(toShow.equals(Color.RED)){
            setColor(toShow.getColor()[0], SSTOP, NSTOP);
            this.setImage("GUI/src/main/resources/com/example/gui/Images/simplecrossing.png");
        } else if(toShow.equals(Color.GREEN)){
            setColor(toShow.getColor()[0], NGO, SGO);
            this.setImage("GUI/src/main/resources/com/example/gui/Images/peds_going_simplecrossing.png");
        }
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
