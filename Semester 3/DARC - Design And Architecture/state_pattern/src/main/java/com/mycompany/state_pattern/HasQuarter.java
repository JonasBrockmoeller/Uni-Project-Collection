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
public class HasQuarter implements State {

    GumballMaschine gb;

    public HasQuarter(GumballMaschine gb) {
        this.gb = gb;
    }

    @Override
    public void insertQuarter() {
        System.out.println("A Quarter was already inserted");
    }

    @Override
    public void ejectsQuarter() {
        System.out.println("The Quarter was ejected!");
        gb.changeState( new NoQuarter(gb) );
    }

    @Override
    public void turnsCrank() {
        System.out.println("The Gumball is sold!");
        gb.changeState( new GumballSold(gb) );
    }

    @Override
    public void dispense() {
        System.out.println("Please turn the crank first!");
    }
    
}
