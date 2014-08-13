<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateTestUserCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'user:make-random';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Make random user into database.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}
    
    private $first_names = [
        'Веселый',
        'Грустный',
        'Находчивый',
        'Забавный',
        'Трепливый',
        'Стебливый',
        'Длинношеий',
        'Задумчивый',
        'Надоедливый',
        'Ехидный',
        'Кровожадный',
        'Хищный',
    ];
    
    private $last_names = [
        'Слон',
        'Гиппопотам',
        'Жираф',
        'Индюк',
        'Страус',
        'Кот',
        'Павлин',
        'Медведь',
        'Фламинго',
        'Гепард',
        'Леопард',
        'Коала',
        'Ленивец',
        'Утконос',
        'Колибри',
    ];
    
    private $photos = [
        'http://vipstraus.kiev.ua/images/black2.jpg',
        'http://www.origins.org.ua/pictures/shutterstock_1542220.jpg',
        'http://animalpicture.ru/wp-content/uploads/2009/09/510.jpg',
        'http://www.symbolsbook.ru/images/P/Petuh.jpg',
        'http://tattoo-pro.ru/upload//images/Animals/Wolf/wasya29111.jpg',
        'http://www.goldensites.ru/media/1/20090407-b_469_2.jpg',
        'http://www.zooclub.ru/attach/birds/292.jpg',
        'http://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Giraffe_standing.jpg/265px-Giraffe_standing.jpg',
        'http://cs305707.vk.me/v305707222/4949/qJXr5hxBLoM.jpg',
        'http://ru.fishki.net/picsw/092012/26/post/kot/kot-0002.jpg',
        'http://krasview.ru/content/thread-image/597780/bcb5aca6628c26bf8c3d20bcb13f8435.jpg',
        'http://album.foto.ru/photos/or/137491/13978.jpg',
        'http://crosti.ru/patterns/00/02/40/388ff70301/%D0%A1%D0%B5%D1%80%D1%8B%D0%B9%20%D0%BA%D0%BE%D1%82-2.jpg',
        'http://img0.liveinternet.ru/images/attach/c/4/83/699/83699980_3921373_46105_or.jpg',
        'http://100-000-pochemu.info/wp-content/uploads/2010/04/11.jpg',
        'http://avivas.ru/img/news/201204/37096574695.jpg',
        'http://cs11510.userapi.com/u12059117/154613384/z_b2bd72a7.jpg',
        'http://www.hqoboi.com/img/animals/leopard_09.jpg',
        'http://farm5.static.flickr.com/4149/5202307151_6127b77318_b.jpg',
        'http://upload.wikimedia.org/wikipedia/commons/0/03/Panthera_pardus_close_up.jpg',
        'http://s6.pikabu.ru/post_img/2014/04/29/6/1398755588_1808484118.jpg',
        'http://www.zoopicture.ru/assets/2011/01/3648183171_785a2ef0a7.jpg',
        'http://www.murzilka.org/data/files/Image/05.2009/koala2.jpg',
        'http://www.animalsglobe.ru/wp-content/uploads/2011/10/koala-11.jpg',
        'http://latindex.ru/upload/iblock/b3e/lenives.jpg',
        'http://cs418423.vk.me/v418423422/4aaa/9exWTzKa3o4.jpg',
        'http://www.spletnik.ru/img/__post/48/480df771121934b2c6af199987472d4c_762.jpg',
        'http://s4.pikabu.ru/images/big_size_comm/2014-05_4/14002447556329.gif',
        'http://cs402319.vk.me/u173693059/a_e02aedba.jpg',
        'http://img1.wikia.nocookie.net/__cb20130716182440/pokemon/ru/images/7/77/Pikachu.png',
        'http://lurkmore.so/images/thumb/7/78/Slowpoke.svg/200px-Slowpoke.svg.png',
    ];

    private function ar_rand (array $arr)
    {
        return $arr[array_rand($arr)];
    }
    
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $count = $this->argument ('count');
        if ($count === null)
            $this->make();
        else
            for (; $count > 0; --$count)
            $this->make();
	}
    
    private function make()
    {
        $user = \Karma\Entities\User::create([
            'first_name' => $this->ar_rand($this->first_names),
            'last_name'  => $this->ar_rand($this->last_names),
            'photo'      => $this->ar_rand($this->photos),
        ]);
        $this->info("User $user->first_name $user->last_name successfully created!");
    }

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
            ['count', InputArgument::OPTIONAL, '', null]
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
		);
	}

}
