import classnames from 'classnames';

const SukiControlDescription = ( { children, className, id } ) => {
	return (
		<>
			<span
				className={ classnames( className, 'description', 'customize-control-description' ) }
				id={ id }
			>
				{ children }
			</span>
		</>
	);
}

export default SukiControlDescription;
