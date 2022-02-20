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
public class ForecastDisplay implements Observer, DisplayElement{

    private float temperature;
    private float humidity; 
    private float pressure;
    
    @Override
    public void update(float temperature, float humidity, float pressure) {
        this.temperature = temperature;
        this.humidity = humidity;
        this.pressure = pressure;
    }

    @Override
    public void display() {
        System.out.println("Here is the Weather forecast:\n" + 
                "Temp = " + (temperature-3) + "\n" +
                "Hum = " + (humidity-3) + "\n" +
                "pres = " + (pressure-3) + "\n" );
    }
    
}
