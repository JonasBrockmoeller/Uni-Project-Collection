/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.observer_pattern;

/**
 *
 * @author jonasbrockmoller
 */
public class StatisticsDisplay implements Observer, DisplayElement{

    private float temperature;
    private float humidity; 
    private float pressure;
    private int rounds;
    
    @Override
    public void update(float temperature, float humidity, float pressure) {
        this.temperature += temperature;
        this.humidity += humidity;
        this.pressure += pressure;
        rounds ++;
    }

    @Override
    public void display() {
        System.out.println("Here are the average weather statistics:\n" + 
                "Temp = " + temperature/rounds + "\n" +
                "Hum = " + humidity/rounds + "\n" +
                "pres = " + pressure/rounds + "\n" );
    }
    
}
