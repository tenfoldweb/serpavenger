<?php
class Jpgraph {
    function linechart($title='Line Chart')
    {
        require_once("jpgraph/jpgraph.php");
        require_once("jpgraph/jpgraph_line.php");    

        // Create the graph. These two calls are always required
        $graph = new Graph(700,400,"auto",60);
        $graph->SetScale("textlin");

        // Setup title
        $graph->title->Set($title);

        //// Create the linear plot
        //$lineplot=new LinePlot($ydata);
        //$lineplot->SetColor("blue");
        //
        //// Add the plot to the graph
        //$graph->Add($lineplot);

        return $graph; // does PHP5 return a reference automatically?
    }
    
    function addlineplot($ydata, $xdata=false){
        require_once("jpgraph/jpgraph.php");
        require_once("jpgraph/jpgraph_line.php");
        // Create the linear plot
        $lineplot=new LinePlot($ydata, $xdata);
        $lineplot->SetColor("blue");
        return $lineplot;
        // Add the plot to the graph
        //$graph->Add($lineplot);
    }
}