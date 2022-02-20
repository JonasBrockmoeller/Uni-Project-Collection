/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Factory;

import Ingedirents.Cheese;
import Ingedirents.Clams;
import Ingedirents.Dough;
import Ingedirents.FreshClams;
import Ingedirents.MarinaraSauce;
import Ingedirents.Reggiano;
import Ingedirents.Sauce;
import Ingedirents.ThinCrustDough;

/**
 *
 * @author jonasbrockmoller
 */
public class NYIngredientFactory implements PizzaIngredientFactory {

    @Override
    public Dough createDough() {
        return new ThinCrustDough();
    }

    @Override
    public Sauce createSauce() {
        return new MarinaraSauce();
    }

    @Override
    public Cheese createCheese() {
        return new Reggiano();
    }

    @Override
    public Clams createClam() {
        return new FreshClams();
    }
    
}
