# Intelligent Traffic Control (ITC)
## Design patterns

### Strategy pattern
It's easy to switch between different algorithms (strategies) in runtime <br/>
![StrategyPattern](/Analisys_Artefacts/PatternsUML/StrategyPattern.png)

### Command pattern
It decouples the classes that invoke the operation from the object that knows how to execute the operation and it allows you to create a sequence of commands <br/>
![CommandPattern](/Analisys_Artefacts/PatternsUML/CommandPattern.png)

### Observer pattern
It supports the principle of loose coupling between objects that interact with each other. It allows sending data to other objects effectively without any change in the Subject or Observer classes. Observers can be added/removed at any point in time. <br/>
![ObserverPattern](/Analisys_Artefacts/PatternsUML/ObserverPattern.png)

### Factory pattern
It is used to simplified the object instanciation which makes the code reusable, extensible and testable
![FactoryPattern](/Analisys_Artefacts/PatternsUML/FactoryPattern.png)

## Use Case Diagram
![Use Case Diagram](/Analisys_Artefacts/UseCaseDiagram1.png)

## Class Diagram
![Class Diagram](/Analisys_Artefacts/ClassDiagram_FinalVersion.svg)

## Roadmap

### 1.Single light control
Control of a single pedestrian light showing red and green<br/>
a) Typical pedestrian light behaviour: RED -> GREEN -> RED<br/>
b) Extended pedestrian light behaviour: RED -> GREEN -> GREEN BLINKING -> RED<br/>
   Control of a single traffic light showing red, green and yellow<br/>
a) Standard traffic light behaviour (Germany): RED -> RED/YELLOW -> GREEN -> YELLOW -> RED<br/>
b) Standard traffic light behaviour (The Netherlands): RED -> GREEN -> YELLOW -> RED<br/>
* Additional signals, e.g. Green Arrow (Germany)<br/>
* Additional modes, e.g. night mode (blinking)<br/>
* Different lights, like Donkey in Wesel (Germany) or Mainzelmännchen in Mainz (Germany) are realized by different shapes.<br/>

 

### 2.Crossings
* Simple pedestrian crossing with two pedestrian lights.<br/>
* Four way traffic crossing (intersections). Opposite lanes will get the same signal.<br/>
* Four way traffic crossing (intersections) including pedestrian lights.<br/>
* Additional signals, e.g. Green Arrow (Germany)<br/>
* Additional modes, e.g. emergency (ambulance/police/president) with green light on one side only and red on all others or night mode (blinking)<br/>
 

### 3.Basic control
Neighbouring crossings/intersections act together<br/>
* Green wave<br/>
* Rush hour outbound<br/>
* Rush hour inbound<br/>
* Emergency<br/>
* Events (exhibitions/festivals)<br/>
 

### 4.Intelligent Control
* Crossings count traffic and adjust signalling times accordingly<br/>
* Crossings detects cars and adjust signalling accordingly (intelligent night mode – single approaching car)<br/>
* Crossings communicate with cars and adjust signalling times/signalling sequence accordingly<br/>
* Crossings communicate with cars and each other and adjust signalling times/signalling sequence accordingly<br/>
 
 
Although application of [design patterns](https://github.com/FontysVenlo/exercises-JonasBrockmoeller) is expected, do not do so without reason. Sometimes it is better to not apply a [pattern](https://github.com/FontysVenlo/exercises-JonasBrockmoeller). Students are expected to reason why a specific pattern is/is not applied.

