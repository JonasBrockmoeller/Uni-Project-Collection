/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author jonasbrockmoller
 */
public class Speak implements QuackBehaviour{

    @Override
    public void quack() {
        System.out.println("I can Speak!");
    }
    
}
