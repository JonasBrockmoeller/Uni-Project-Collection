/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author jonasbrockmoller
 */
public class DecoyDuck extends Duck{
    
    public DecoyDuck() {
        super.setFlyBehaviour(new FlyNoWay());
        super.setQuackBehaviour(new Quack());
    }
    
    public void display(){
        System.out.println("Looks like a decoy");
    }
}
