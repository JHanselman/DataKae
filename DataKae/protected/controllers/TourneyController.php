<?php

class TourneyController extends Controller
{
    public function actionGenerator()
    {
        $this->render('TourneyBracket');
    }
}