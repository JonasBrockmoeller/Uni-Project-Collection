/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author jonasbrockmoller
 */
public class Duck {
    
    FlyBehaviour fb;
    QuackBehaviour qb;
    
    public void swim(){
        System.out.println("swimming..");
    }
    
    public void quack(){
        qb.quack();
    }
    
    public void fly(){
        fb.fly();
    }
    
    public void setFlyBehaviour(FlyBehaviour f){
        fb = f;
    }
    
    public void setQuackBehaviour(QuackBehaviour q){
        qb = q;
    }
}
