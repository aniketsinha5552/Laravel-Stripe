import SubCard from '@/Components/SubCard';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import axios from 'axios';
import { useEffect, useState } from 'react';


export default function Dashboard(props) {
    const [plans,setPlans]= useState([])
    const [currPlan,setCurrPlan]= useState();
    const getPlans=async()=>{
        let res =await axios.get('/plans')
        setPlans(res.data)
        let res2 =await axios.post('/user-plan',{
            user_id:props?.auth?.user?.id
        })
        setCurrPlan(res2.data)
    }
    useEffect(()=>{
        getPlans();
    },[])
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Manage Subscriptions</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <p>Current Plan : <span className="text-xl font-bold">{currPlan?.name??"No Plan"}</span></p>
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col md:flex-row justify-center gap-10">
                       {plans?.map(tier=>{
                        return <SubCard tier={tier} user={props.auth?.user} currPlan={currPlan}/>
                       })}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
