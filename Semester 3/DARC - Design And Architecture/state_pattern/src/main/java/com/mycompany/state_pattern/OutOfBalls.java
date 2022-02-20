/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.state_pattern;

/**
 *
 * @author jonasbrockmoller
 */
public class OutOfBalls implements State{

    GumballMaschine gb;

    public OutOfBalls(GumballMaschine gb) {
        this.gb = gb;
    }
    
    @Override
    public void insertQuarter() {
        System.out.println("The maschine is out of Balls! Waiting for refill!");
    }

    @Override
    public void ejectsQuarter() {
        System.out.println("The maschine is out of Balls! Waiting for refill!");
    }

    @Override
    public void turnsCrank() {
        System.out.println("The maschine is out of Balls! Waiting for refill!");
    }

    @Override
    public void dispense() {
        System.out.println("The maschine is out of Balls! Waiting for refill!");
    }
    
}
