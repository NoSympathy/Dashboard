Imports Models
Imports Newtonsoft.Json
Public Class pvpconfigurations
    Inherits BaseController
    Public Function GetPvPStats(access_token As String) As PVP
        Dim endPoints = New Uri(String.Format(APICore.Gw2Endpoints.BaseUrl + APICore.Gw2Endpoints.PvPStats + "?access_token={0}", access_token))

        Dim jsonres = GetApiDataByUriJson(endPoints)

        Dim ret = JsonConvert.DeserializeObject(Of PVP)(jsonres)

        Return ret
    End Function
End Class
