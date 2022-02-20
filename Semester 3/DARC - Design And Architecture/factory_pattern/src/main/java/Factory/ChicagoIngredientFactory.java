/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Factory;

import Ingedirents.Cheese;
import Ingedirents.Clams;
import Ingedirents.Dough;
import Ingedirents.FrozenClams;
import Ingedirents.Mozzarella;
import Ingedirents.PlumTomatoSauce;
import Ingedirents.Sauce;
import Ingedirents.TickCrustDough;

/**
 *
 * @author jonasbrockmoller
 */
public class ChicagoIngredientFactory implements PizzaIngredientFactory {

    @Override
    public Dough createDough() {
        return new TickCrustDough();
    }

    @Override
    public Sauce createSauce() {
        return new PlumTomatoSauce();
    }

    @Override
    public Cheese createCheese() {
        return new Mozzarella();
    }

    @Override
    public Clams createClam() {
        return new FrozenClams();
    }

}
