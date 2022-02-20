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
public class GumballSold implements State {
    
    GumballMaschine gb;
    
    public GumballSold(GumballMaschine gb) {
        this.gb = gb;
    }
    
    @Override
    public void insertQuarter() {
        System.out.println("Please dispense the gumball before inserting another Quarter!");
    }
    
    @Override
    public void ejectsQuarter() {
        
    }
    
    @Override
    public void turnsCrank() {
        System.out.println("Please wait for the Gumball to be dispensed!");
    }
    
    @Override
    public void dispense() {
        if (gb.getBalls() > 0) {
            System.out.println("The Gumball is being dispensed now!");
            gb.changeState(new NoQuarter(gb));
        } else {
            System.out.println("The Gumball maschine is out of Gumballs. Here is your Quarter");
            gb.changeState(new OutOfBalls(gb));
        }
        gb.setBalls(gb.getBalls() - 1);
    }
    
}
