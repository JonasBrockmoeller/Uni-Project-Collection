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
public class Main {

//    private static CurrentConditionsDisplay d1 = new CurrentConditionsDisplay();
//    private static ForecastDisplay d2 = new ForecastDisplay();
//    private static StatisticsDisplay d3 = new StatisticsDisplay();
//    private static ThirdPartyDisplay d4 = new ThirdPartyDisplay();
    
    public Main() {
//        this.start();
    }

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        CurrentConditionsDisplay d1 = new CurrentConditionsDisplay();
        ForecastDisplay d2 = new ForecastDisplay();
        StatisticsDisplay d3 = new StatisticsDisplay();
        ThirdPartyDisplay d4 = new ThirdPartyDisplay();
        
        WeatherData w1 = new WeatherData(28, 60, 2);
        w1.registerObserver( d1 );
        w1.registerObserver( d2 );
        w1.registerObserver( d3 );
        w1.registerObserver( d4 );
        
        w1.notifyObservers();
        
        d1.display();
        
        w1.setHumidity(100);
        
        d2.display();
        
        w1.setTemperature(007);
        
        d3.display();
        
        w1.setPressure(1000000);
        
        d4.display();
        
        w1.setHumidity(1);
        w1.setTemperature(2);
        w1.setPressure(3);
        
        System.out.println("CurrentConditionsDisplay");
        d1.display();
        System.out.println("=====");
        System.out.println("ForecastDisplay");
        d2.display();
        System.out.println("=====");
        System.out.println("StatisticsDisplay");
        d3.display();
        System.out.println("=====");
        System.out.println("ThirdPartyDisplay");
        d4.display();
        System.out.println("=====");
    }
    
    
    public void start(){
        CurrentConditionsDisplay d1 = new CurrentConditionsDisplay();
        ForecastDisplay d2 = new ForecastDisplay();
        StatisticsDisplay d3 = new StatisticsDisplay();
        ThirdPartyDisplay d4 = new ThirdPartyDisplay();
        
        WeatherData w1 = new WeatherData(28, 60, 2);
        w1.registerObserver( d1 );
        w1.registerObserver( d2 );
        w1.registerObserver( d3 );
        w1.registerObserver( d4 );
        
        w1.notifyObservers();
        
        d1.display();
        
        w1.setHumidity(100);
        
        d2.display();
        
        w1.setTemperature(007);
        
        d3.display();
        
        w1.setPressure(1000000);
        
        d4.display();
        
        w1.setHumidity(1);
        w1.setTemperature(2);
        w1.setPressure(3);
        
        System.out.println("CurrentConditionsDisplay");
        d1.display();
        System.out.println("=====");
        System.out.println("ForecastDisplay");
        d2.display();
        System.out.println("=====");
        System.out.println("StatisticsDisplay");
        d3.display();
        System.out.println("=====");
        System.out.println("ThirdPartyDisplay");
        d4.display();
        System.out.println("=====");
    }
    
}
