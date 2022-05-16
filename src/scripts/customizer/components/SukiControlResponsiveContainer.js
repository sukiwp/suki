import classnames from 'classnames';

function SukiControlResponsiveContainer( { children, className, device } ) {
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