/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.adapter_pattern;

/**
 *
 * @author jonasbrockmoller
 */
public class DroneAdapter implements Duck {

    private Drone drone;

    public DroneAdapter(SuperDrone drone) {
        this.drone = drone;
    }

    @Override
    public void quack() {
        drone.beep();
    }

    @Override
    public void fly() {
        drone.spinRotors();
        drone.takeOff();
    }

    public void setDrone(Drone drone) {
        this.drone = drone;
    }
}
