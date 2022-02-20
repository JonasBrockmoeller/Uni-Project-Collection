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
public class NewMain {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        GumballMaschine gb = new GumballMaschine(1);
        
        gb.getState().insertQuarter();
        gb.getState().turnsCrank();
        gb.getState().dispense();
        
        gb.getState().dispense();
        
        gb.getState().insertQuarter();
        gb.getState().ejectsQuarter();
        gb.getState().insertQuarter();
        gb.getState().turnsCrank();
        gb.getState().dispense();
    }
    
}
