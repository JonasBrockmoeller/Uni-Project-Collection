/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author jonasbrockmoller
 */
public class RedheadDuck extends Duck {
    
    public RedheadDuck() {
        super.setFlyBehaviour(new FlyWithWings());
        super.setQuackBehaviour(new Speak());
    }
    
    public void display(){
        System.out.println("Looks like a redhead");
    }
}
