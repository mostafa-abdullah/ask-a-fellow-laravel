<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name' ,'email', 'password', 'major', 'semester', 'bio'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Returns the major this user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function major()
    {
        return $this->belongsTo('App\Major');
    }

    /**
     * Return list of questions asked by this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions(){
        return $this->hasMany('App\Question','asker_id');
    }


    /**
     * Return list of answers posted by this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers(){
        return $this->hasMany('App\Answer','responder_id');
    }

    /**
     * Get a list of notifications of this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications(){
        return $this->hasMany('App\Notification');
    }


    /**
     * Votes on answers done by this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answer_votes()
    {
        return $this->hasMany('App\AnswerVote');
    }

    public function upvotesOnAnswer($id){
        return $this->hasMany('App\AnswerVote')->where('type','=',0)->where('answer_id','=',$id)->get();
    }

    public function downvotesOnAnswer($id){
        return $this->hasMany('App\AnswerVote')->where('type','=',1)->where('answer_id','=',$id)->get();
    }




    /**
     * Votes on questions done by this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function question_votes()
    {
        return $this->hasMany('App\QuestionVote');
    }

    public function upvotesOnQuestion($id){
        return $this->hasMany('App\QuestionVote')->where('type','=',0)->where('question_id','=',$id)->get();
    }

    public function downvotesOnQuestion($id){
        return $this->hasMany('App\QuestionVote')->where('type','=',1)->where('question_idd','=',$id)->get();
    }


    /**
     * Return a list of courses subscribed by this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subscribed_courses()
    {
        return $this->belongsToMany('App\Course','subscribe');
    }


    /**
     * Subscribe to a certain course
     * @param $course_id
     */
    public function subscribe_to_course($course_id)
    {
        $this->subscribed_courses()->attach($course_id);
    }


    /**
     * Subscribe to a whole major
     * @param $major_id
     */
    public function subscribe_to_major($major_id)
    {
        $major = Major::find($major_id);
        $courses = $major->courses();
        foreach($courses as $course)
        {
            $this->subscribe_to_course($course->id);
        }
    }




    /**
     * Upvote or downvote a question.
     * @param $question_id
     * @param $type
     */

    public function vote_on_question($question_id,$type)
    {
        $questionVote = new QuestionVote();
        $questionVote->user_id = $this>id;
        $questionVote->type = $type;
        $questionVote->question_id = $question_id;
        $questionVote->save();
    }


    /**
     * Upvote or downvote an answer.
     * @param $answer_id
     * @param $type
     */
    public function vote_on_answer($answer_id,$type)
    {
        $answerVote = new AnswerVote();
        $answerVote->user_id = $this>id;
        $answerVote->type = $type;
        $answerVote->answer_id = $answer_id;
        $answerVote->save();
    }



    /*
     * Admin roles:
     * - Create major
     * - Create course
     * - Delete major
     * - Delete course
     * - Delete question
     * - Delete answer
     */


    public function create_major($major_name, $faculty_name)
    {
        if($this->role != 1)
            return;
        $major = new Major();
        $major->major = $major_name;
        $major->faculty = $faculty_name;
        $major->save();
    }


    public function create_course($course_code, $course_name, $course_code)
    {
        if($this->role != 1)
            return;
        $course = new Course();
        $course->course_name = $course_name;
        $course->course_code = $course_code;
        $course->semester = $course_code;
        $course->save();
    }


    public function delete_major($major_id)
    {
        if($this->role != 1)
            return;
        $major = Major::find($major_id);
        $major->delete();
    }

    public function delete_course($course_id)
    {
        if($this->role != 1)
            return;
        $course = Course::find($course_id);
        $course->delete();
    }


    public function delete_question($question_id)
    {
        if($this->role != 1)
            return;
        $question = Question::find($question_id);
        $question->delete();
    }

    public function delete_answer($answer_id)
    {
        if($this->role != 1)
            return;
        $answer = Answer::find($answer_id);
        $answer->delete();
    }

}