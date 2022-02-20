/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.observer_pattern;

import java.util.ArrayList;
import java.util.List;

/**
 *
 * @author jonasbrockmoller
 */
public class WeatherData implements Subject {

    private float temperature;
    private float humidity;
    private float pressure;
    private List<Observer> observer = new ArrayList<>();

    public WeatherData(float temperature, float humidity, float pressure) {
        this.temperature = temperature;
        this.humidity = humidity;
        this.pressure = pressure;
    }
    
    @Override
    public void registerObserver(Observer o) {
        observer.add(o);
    }

    @Override
    public void removeObserver(Observer o) {
        observer.remove(o);
    }

    @Override
    public void notifyObservers() {
        observer.forEach(_item -> {
            _item.update(temperature, humidity, pressure);
        });
    }

    public float getTemperature() {
        return temperature;
    }

    public float getHumidity() {
        return humidity;
    }

    public float getPressure() {
        return pressure;
    } 

    public void setTemperature(float temperature) {
        this.temperature = temperature;
        this.notifyObservers();
    }

    public void setHumidity(float humidity) {
        this.humidity = humidity;
        this.notifyObservers();
    }

    public void setPressure(float pressure) {
        this.pressure = pressure;
        this.notifyObservers();
    }
    
    
}
