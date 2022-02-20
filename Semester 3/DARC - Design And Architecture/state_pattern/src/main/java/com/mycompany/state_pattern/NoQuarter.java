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
public class NoQuarter implements State {

    GumballMaschine gb;

    public NoQuarter(GumballMaschine gb) {
        this.gb = gb;
    }

    @Override
    public void insertQuarter() {
        System.out.println("Quarter inserted!");
        gb.changeState(new HasQuarter(gb));
    }

    @Override
    public void ejectsQuarter() {
        System.out.println("please insert a Quarter first!");
    }

    @Override
    public void turnsCrank() {
        System.out.println("please insert a Quarter first!");
    }

    @Override
    public void dispense() {
        System.out.println("please insert a Quarter first!");
    }

}
