/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Store;

import Factory.ChicagoIngredientFactory;
import Factory.NYIngredientFactory;
import Factory.PizzaIngredientFactory;
import Ingedirents.Clams;
import Ingedirents.Dough;
import Ingedirents.Sauce;

/**
 *
 * @author jonasbrockmoller
 */
public class NYPizzaStore {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        PizzaIngredientFactory f = new NYIngredientFactory();
        
        Dough d = f.createDough();
        
        Sauce s = f.createSauce();
        
        Clams c = f.createClam();
        
        f = new ChicagoIngredientFactory();
        
        d = f.createDough();
        
        s = f.createSauce();
        
        c = f.createClam();
    }
    
}
