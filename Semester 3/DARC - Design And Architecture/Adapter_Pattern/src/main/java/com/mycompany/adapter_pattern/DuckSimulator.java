/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Main.java to edit this template
 */
package com.mycompany.adapter_pattern;

/**
 *
 * @author jonasbrockmoller
 */
public class DuckSimulator {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        Duck duck = new Mallard();
        testDuck(duck);
        
        Turkey turkey = new WildTurkey();
        Duck adapter = new TurkeyAdapter((WildTurkey) turkey);
        testDuck(adapter);
        
        Drone drone = new SuperDrone();
        Duck droneAdapter = new DroneAdapter((SuperDrone) drone);
        testDuck(droneAdapter);
    }
    
    static void testDuck(Duck duck){
        duck.quack();
        duck.fly();
    }
    
}
