/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.adapter_pattern;

/**
 *
 * @author jonasbrockmoller
 */
public class SuperDrone implements Drone {

    @Override
    public void beep() {
        System.out.println("Superdrone beeps");
    }

    @Override
    public void spinRotors() {
        System.out.println("Superdrones rotors start spinning");
    }

    @Override
    public void takeOff() {
        System.out.println("Superdrone takes off");
    }

}
