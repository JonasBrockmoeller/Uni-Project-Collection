/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Factory;

import Ingedirents.Cheese;
import Ingedirents.Clams;
import Ingedirents.Dough;
import Ingedirents.Sauce;

/**
 *
 * @author jonasbrockmoller
 */
public interface PizzaIngredientFactory {
    Dough createDough();
    Sauce createSauce();
    Cheese createCheese();
    Clams createClam();
}
