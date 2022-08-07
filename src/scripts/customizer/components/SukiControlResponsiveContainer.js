import classnames from 'classnames';

const SukiControlResponsiveContainer = ( { children, className, device } ) => {
	return (
		<>
			<div
				className={ classnames( className, 'suki-responsive-container' ) }
				data-device={ device }
			>
				{ children }
			</div>
		</>
	);
}

export default SukiControlResponsiveContainer;
