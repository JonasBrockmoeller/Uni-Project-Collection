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
public interface State {
    
    void insertQuarter();
    
    void ejectsQuarter();
    
    void turnsCrank();
    
    void dispense();      
}
