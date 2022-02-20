/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.observer_pattern;

/**
 *
 * @author jonasbrockmoller
 */
public interface Observer {
    void update(float temperature, float humidity, float pressure);
}
