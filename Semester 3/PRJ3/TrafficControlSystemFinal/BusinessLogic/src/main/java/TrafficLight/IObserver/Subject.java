package TrafficLight.IObserver;

public interface Subject {
    void registerObserver(Observer obeserver);
    void removeObserver();
    void notifyObserver();  
}
