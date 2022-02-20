package com.example.gui;

import TrafficLight.BehaviourImplementations.Pedestrian.DutchPedestrian;
import TrafficLight.BehaviourImplementations.Pedestrian.GermanPedestrian;
import TrafficLight.Entities.ILight;
import TrafficLight.Entities.PedestrianLight;
import TrafficLight.Enum.Color;
import TrafficLight.Enum.Direction;
import TrafficLight.Factory.PedestrianLightFactory;
import TrafficLight.UIOberserver.UIObserver;
import javafx.concurrent.Task;
import javafx.fxml.FXML;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;

import java.io.IOException;
import java.net.MalformedURLException;
import java.nio.file.Path;
import java.nio.file.Paths;

public class PedestrianLightController implements UIObserver {
    private Thread getItemsThread;
    private PedestrianLight light;
    private PedestrianLightFactory pFactory = new PedestrianLightFactory();
    public ImageView backgroundImage = new ImageView();

    public PedestrianLightController() {
        light = pFactory.createDutch(Direction.STRAIGHT);
        light.registerUIObserver(this);
    }

    @FXML
    public void start() {
        //Use this codebook if javafx does not update properly
        Task startCrossing = new Task<>() {
            @Override
            protected Object call() throws Exception {
                light.lightBehaviour.request(light);
                return null;
                //should be changed so it goes over the Command
            }
        };
        getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(false);
        getItemsThread.start();
    }

    @FXML
    public void stop() {
        if(getItemsThread != null) getItemsThread.stop();
        Task startCrossing = new Task<>() {
        @Override
        protected Object call() throws Exception {
            light.lightBehaviour.stop(light);
            return null;
            //should be changed so it goes over the Command
        }
    };
        getItemsThread = new Thread(startCrossing);
        getItemsThread.setDaemon(true);
        getItemsThread.start();

    }

    @FXML
    public void setEmergency() {
        if(getItemsThread != null) getItemsThread.stop();
        Task Emergency = new Task<>() {
            @Override
            protected Object call() throws Exception {
                light.getLightBehaviour().emergency(light);
                return null;
            }
        };
        getItemsThread = new Thread(Emergency);
        getItemsThread.setDaemon(true);
        getItemsThread.start();
    }
    @FXML
    public void setNightmode() {
        if(getItemsThread != null) getItemsThread.stop();
        Task Nightmode = new Task<>() {
            @Override
            protected Object call() throws Exception {
                light.getLightBehaviour().nightMode(light);
                return null;
            }
        };
        getItemsThread = new Thread(Nightmode);
        getItemsThread.setDaemon(true);
        getItemsThread.start();
    }
    @FXML
    public void setDutchBehaviour() {
        light.setLightBehaviour(new DutchPedestrian());
    }
    @FXML
    public void setGermanBehaviour() {
        light.setLightBehaviour(new GermanPedestrian());
    }

    @FXML
    public void goHome() throws IOException {
        if(getItemsThread != null) getItemsThread.stop();
        Application.setRoot("MainApp");
    }

    @Override
    public void update(ILight light, Color toShow) {
        if(light.getClass().equals(PedestrianLight.class)){
            this.updatePedestrianLights(toShow);
        }
        try {
            Thread.sleep(1000);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
    }

    public void updatePedestrianLights(Color toShow){
        if(toShow.equals(Color.RED)){
            this.setImage("GUI/src/main/resources/com/example/gui/Images/PedestrianStop.jpg");
        } else if(toShow.equals(Color.GREEN)){
            this.setImage("GUI/src/main/resources/com/example/gui/Images/PedestrianGo.jpg");
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
}