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
public class GumballMaschine {
    
    State state;
    int balls;

    public GumballMaschine(int balls) {
        state = new NoQuarter(this);
        this.balls = balls;
    }
    
    public void changeState(State s){
        this.state = s;
    }

    public State getState() {
        return state;
    }

    public int getBalls() {
        return balls;
    }

    public void setBalls(int balls) {
        this.balls = balls;
    }
    
    
}
