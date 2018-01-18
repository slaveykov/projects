<?php
	/**
	 * Раздайте сладолед на децата
	 * 
	 * Условие на задачата:
	 *
	 * На опашка стоят N деца, като всяко от тях има оценка. Вие им раздавате сладолед според следните правила:
	 * 1. Всяко дете трябва да получи сладолед
	 * 2. Ако едно дете има по-голяма оценка от съседно на опашката то трябва да получи повече сладоледи от въпросното съседно
	 *
	 * Обърнете внимание, че с изключение на първото и последното, всяко дете има по 2 съседни деца.
	 * Тоест ако едно (или и двете) от децата преди или след дете X има по-ниска оценка,
	 * то въпросото дете X трябва да получи повече сладоледи от детето с по-ниска оценка.
	 * Две деца с еднакви оценки едно до друго могат да получат различен брой сладоледи.
	 * 
	 * Колко е минималния брой необходими сладоледи ? Колко сладоледи получава всяко от децата в тази ситуация?
	 */

	function getIcecreamsCount(array $children){
		
		/*
		 * Стъпки за решаването на задачата. 
		 * 1. Сортираме най-ниските оценки и запомняме тяхните позиции
		 * 2. Завъртаме цикъл със сортираните оценки
		 * 3. Записваме съседите от ляво и дясно
		 * 4. Проверяваме дали съответното дете има по-голяма оценка от съседните си.
		 * 5. Добавяме +1 сладолед за децата, котио имат по-големи оценки от съседите си. 
		 */
		
		$sortChildren = $children;
		asort($sortChildren); //sorted
		
		$icereams = array();
		
		foreach($sortChildren as $childPosition=>$childRate){
			
			$child = array();
			$child['position'] = $childPosition;
			$child['rate'] = $childRate;
			$child['icecream'] = 1;
			
			$neighbour_left_position = false;
			$neighbour_right_position = false;
			$neighbour_left_rate = false;
			$neighbour_right_rate = false;
			
			if(isset($sortChildren[$childPosition-1])){
				$neighbour_left_position = $childPosition-1;
				$neighbour_left_rate = $sortChildren[$childPosition-1];
			}
			
			if(isset($sortChildren[$childPosition+1])){
				$neighbour_right_position = $childPosition+1;
				$neighbour_right_rate = $sortChildren[$childPosition+1];
			}
			
			$child['neighbour_left_position'] = $neighbour_left_position;
			$child['neighbour_left_rate'] = $neighbour_left_rate;
			
			$child['neighbour_right_position'] = $neighbour_right_position;
			$child['neighbour_right_rate'] = $neighbour_right_rate;
			
			if($neighbour_left_position !== false && $childRate > $neighbour_left_rate){
				//the child have a greater rate then neighbour left child
				$child['icecream'] = $child['icecream'] + 1;
				
			}
			
			if($neighbour_right_position !== false && $childRate > $neighbour_right_rate){
				//the child have a greater rate then neighbour right child
				$child['icecream'] = $child['icecream'] + 1;
			}
			
			$icereams[] = $child;
			
		}
		
		/*
		 * 7.Завъртаме $icecreams[], записваме децата с тяхната позиция като ключ на масива
		*/
		$childrenPositions = array();
		foreach($icereams as $child){
			$childrenPositions[$child['position']] = $child;
		}
		
		/*
		 * 7.Завъртаме $icecreams[], и проверяваме дали някое от децата
		 * имат по-малко сладоледи от съседните си в случай, че имат по-добра оценка.
		 * 8.Вземаме най-големия брой сладоледи от съседите и прибавяме +1 на съответното дете.
		 */
		
		$calculatedIcecreams = array();
		foreach($icereams as $child){
			
			/*
			if($child['position']!==2){
				continue;
			}
			*/
			
			$neighbours_icecream_max = false;
			
			if($child['neighbour_right_position']!==false){
				$neighbour_right_info = $childrenPositions[$child['neighbour_right_position']];
				if($child['rate'] > $neighbour_right_info['rate']){
					$neighbours_icecream_max = $neighbour_right_info['icecream'];
				}
			}
			
			if($child['neighbour_left_position']!==false){
				$neighbour_left_info = $childrenPositions[$child['neighbour_left_position']];
				if($child['rate'] > $neighbour_left_info['rate']){
					$neighbours_icecream_max = $neighbour_left_info['icecream'];
				}
			}
			
			if(isset($neighbour_right_info) && isset($neighbour_left_info)){
				if($neighbour_right_info['icecream'] > $neighbour_right_info['icecream']){
					if($child['rate']>$neighbour_right_info['rate']){
						$neighbours_icecream_max = $neighbour_right_info['icecream'];
					}
				}
				if($neighbour_left_info['icecream'] > $neighbour_right_info['icecream']){
					if($child['rate']>$neighbour_left_info['rate']){
						$neighbours_icecream_max = $neighbour_left_info['icecream'];
					}
				}
			}
			
			if($neighbours_icecream_max !==false){
				$child['icecream'] = $neighbours_icecream_max + 1;
				$childrenPositions[$child['position']] = $child;
			}
			
			$calculatedIcecreams[$child['position']] = $child;
		}
		
		ksort($calculatedIcecreams);
		
		$countIcecreams = 0;
		
		foreach($calculatedIcecreams as $child){
			$countIcecreams = $countIcecreams + $child['icecream'];
		}
		
		echo $countIcecreams .":"; 
		
		$i=1;
		foreach($calculatedIcecreams as $child){
			echo $child['icecream'];
			if(sizeof($calculatedIcecreams)!==$i){
				echo ',';
			}
			$i++;
		}
		
	}
	
	$children = array(9, 4, 8, 8);
	echo getIcecreamsCount($children);

?>